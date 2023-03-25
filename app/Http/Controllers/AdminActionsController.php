<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\User as userEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
                    //$email=new userEmail();
                    return response()->json([
                        'success' => true,
                        'msg' => 'User added successfully'
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
}
