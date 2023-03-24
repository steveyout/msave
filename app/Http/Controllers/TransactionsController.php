<?php

namespace App\Http\Controllers;

use App\Models\checkouts;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gathuku\Mpesa\Facades\Mpesa;
use App\Models\transactions;
use App\Models\contributions;
use App\Events\payment;

class TransactionsController extends Controller
{
    //initiate deposit
    public function initiateDeposit(Request $request){
        if ($request->has('amount')){
            $user=Auth::user();
            $amount=$request->input('amount');
            $payment = Mpesa::express($amount, $user->phone_no, Env('APP_NAME'), Env('APP_NAME').'deposit');
            if ($payment) {
                $payment_response = json_decode($payment);
                $response = $payment_response->ResponseDescription;
                if ($response == 'Success. Request accepted for processing') {
                    //save the checkout
                    $checkout = $user->checkouts()->updateOrCreate([
                        'checkout_request_id' => $payment_response->CheckoutRequestID
                    ],
                        [
                            'checkout_request_id' => $payment_response->CheckoutRequestID,
                            'merchant_request_id' => $payment_response->MerchantRequestID,
                        ]
                    );

                    if ($checkout) {
                        return response()->json([
                            'success' => true,
                            'msg' => 'A prompt has been sent to your phone,Please check and confirm payment',
                        ]);
                    } else {
                        return response()->json([
                            'success' => false,
                            'msg' => 'OOps something went wrong,please try again later or contact support',
                        ]);
                    }
                }
            } else {
            return response()->json([
                'success' => false,
                'msg' => 'Something wrong happened,Please try again later!'
            ]);
        }
        }else{
            return response()->json([
                'success'=>false,
                'msg'=>'Please enter an amount'
            ]);
        }
    }

    //response
    public function paymentResponse(Request $request){
        $result=$request->all()['Body']['stkCallback'];
        $checkout=checkouts::where([
            'checkout_request_id'=>$result['CheckoutRequestID']
        ])->get();
        if (count($checkout)!==0&&$result) {
            try {
                $msg = $result['ResultDesc'];
                if ($msg == 'Request cancelled by user') {
                    $response = [
                        'success' => false,
                        'msg' => 'Payment was cancelled',
                        'id' => $checkout[0]['user_id'],
                    ];
                    payment::dispatch($response);
                } elseif ($msg == 'The service request is processed successfully.') {
                    $result = $result['CallbackMetadata']['Item'];
                    $amount=$result[0]['Value'];
                    $receipt_number=$result[1]['Value'];
                    $phone_number=$result[4]['Value'];
                    $user=User::find('id',$checkout[0]['user_id']);
                    $transaction=$user->transactions()->create([
                        'amount'=>$amount,
                        'receipt_number'=>$receipt_number,
                        'phone_number'=>$phone_number
                    ]);

                    //update users balance
                    $update=$user->contributions()->create([
                        'amount'=>$amount,
                    ]);


                    $response = ['success' => true,
                        'msg' => 'Payment success',
                        'id' => $user->id,
                    ];
                    //register the transaction and update

                    payment::dispatch($response);
                } elseif ($msg === 'Rule limited.') {
                    $response = [
                        'success' => false,
                        'email' => $checkout[0]['email'],
                        'msg' => 'It seems another transaction is currently underway.Please try again later',
                    ];
                    payment::dispatch($response);
                } else {
                    $response = [
                        'success' => false,
                        'email' => $checkout[0]['email'],
                        'msg' => $msg
                    ];
                    payment::dispatch($response);
                }
            }catch (Throwable $e){
                report($e);
                $response=[
                    'success'=>false,
                    'msg'=>'Something went wrong',
                    'id'=>$user->id,
                ];
                payment::dispatch($response);
            }
        }
        return response(null,200);

    }
}
