<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\User as userEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Faker\Generator;

class AdminActionsController extends Controller
{
    //add new user
    public function addUer(Request $request){
        $is_Admin=Auth::user()->is_admin;
        if ($is_Admin){
            $password=Hash::make(Str::random(10));
            $credentials = $request->validate([
                'name' => ['required'],
                'email' => ['required', 'email','unique:users'],
                'phone_no' => ['required','unique:users'],
                'id_no' => ['required','unique:users'],
            ]);
            $credentials['password']=$password;
                $user = User::updateOrCreate([
                    'email' => $credentials['email']
                ], $credentials);
                if ($user) {
                    //mail
                    $email=Mail::to($user->email)
                        ->queue(new userEmail($credentials));
                    return response()->json([
                        'success' => true,
                        'msg' => 'User added successfully and otp sent via email'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'msg' => 'Oops! Something went wrong'
                    ]);
                }
        }else{
            return response(null,403);
        }
    }

    ///delete User
    public function deleteUser(Request $request){
        $is_Admin=Auth::user()->is_admin;
        if ($is_Admin){
            $id=$request->input('id');
            if ($request->has('id')){
                User::find($id)->delete();
                return response()->json([
                    'success' => true,
                    'msg' => 'User deleted successfully'
                ]);
            }else{
                return response(null,400);
            }
        }else{
            return response(null,403);
        }
    }

    ///delete User
    public function activateUser(Request $request){
        $is_Admin=Auth::user()->is_admin;
        if ($is_Admin){
            $id=$request->input('id');
            if ($request->has('id')){
                $user=User::find($id);
                $is_activated= !$user->is_activated;
                $user->update([
                    'is_activated'=>$is_activated
                ]);
                $status=$is_activated?'activated':'deactivated';
                return response()->json([
                    'success' => true,
                    'msg' => "User $status successfully"
                ]);
            }else{
                return response(null,400);
            }
        }else{
            return response(null,403);
        }
    }
    ////generate random users
    public function generateUsers(Request $request,Generator $faker){
        $users=User::count();
        if ($users>=10){
            return response()->json([
                'success'=>false,
                'msg'=>'Users already generated'
            ]);
        }else{
            for ($i=0;$i<9;$i++){
                User::create([
                    'name' => $faker->name(),
                    'email'=>preg_replace('/@example\..*/', '@gmail.com', $faker->unique()->safeEmail),
                    'password'=>Hash::make($faker->password()),
                    'phone_no'=>$faker->phoneNumber(),
                    'id_no'=>$faker->randomDigitNotNull()
                ]);
            }
            return response()->json([
                'success'=>true,
                'msg'=>'Users generated'
            ]);
        }
    }
    ////simulate transactions
    public function simulateTransactions(Request $request,Generator $faker){
        $users=User::all();
        foreach ($users as $user){
            $amount=$faker->numberBetween(100,10000);
            $user->transactions()->create([
                'amount'=>$amount,
                'receipt_number'=>$faker->randomNumber(5, true),
                'phone_number'=>$faker->phoneNumber()
            ]);
            $user->contributions()->create([
                'amount'=>$amount
            ]);
        }
        return response()->json([
            'success'=>true,
            'msg'=>'Transactions simulated'
        ]);

    }
}
