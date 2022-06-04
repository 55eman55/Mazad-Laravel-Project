<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\Notifications\ResetPasswordNotification;
use App\Models\User;
use App\Http\Controllers\API\BaseController as BaseController;


class NewPasswordController extends BaseController
{

    public function forgotPassword(Request $request){
        $input = $request->only('email');
        $validator = Validator::make($input, [
            'email' => "required|email"
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $response = Password::sendResetLink($input);

        $message = $response == Password::RESET_LINK_SENT ? 'Mail send successfully' : 'this email is in correct';

        return response()->json(['status'=>'true','message'=>$message,'data'=>'null']);
    }
        public function passwordReset(Request $request){
            $input = $request->only('email','token', 'password', 'password_confirmation');
            $validator = Validator::make($input, [
                'token' => 'required',
                'email' => 'required|email',
                'password' => 'required|confirmed|min:8',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }
            $response = Password::reset($input, function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            });
            $message = $response == Password::PASSWORD_RESET ? 'Password reset successfully' : 'this email is in correct';
            return response()->json(['status'=>'true','message'=>$message,'data'=>'null']);
        }
}
