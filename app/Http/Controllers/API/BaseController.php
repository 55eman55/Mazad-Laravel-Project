<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as Controller ;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    //
    public function sendResponse($messge, $result)
    {
        $response = [

            'status' => true,
            'message'=>$messge,
            'data' =>$result

        ];
        return response()->json( $response , 200);
    }
    public function sendError($error , $errorMessge=[], $code =404)
    {
        $response = [

            'status' => false,
            'message' =>$error,
            'data'  =>null,
            ];

        if(!empty($errorMessge)){
            $response ['message'] =$errorMessge;

        }
        return response()->json( $response ,  $code);
    }
    public function get_user_token( $user, string $token_name = null ) {

        return $user->createToken($token_name)->accessToken;

     }


}
