<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\comment;
use Illuminate\Http\Request;
use App\Models\react;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
class ReactController extends BaseController
{
    public function comment(Request $request)
    {

     $request->validate([

         'comment' => 'required',

      ]);

      $user = $request;
     $comment=new react();
     $comment->user_id=$user->user_id;
     $comment->product_id=$request->product_id;
     $comment->comment=$request->comment;
     $comment->save();
     return response()->json(['status' => 'true', 'message' => 'product commented', 'data' => $comment]);

     }
     public function showComments(Request $request)
     {

        $comments = react::with('usercomment:id,name,profile_picture')->where('product_id', $request->product_id)->get();

         if($comments!=null){


            return $this->returnData('data', $comments);
         }

              return response()->json(['comments'=>"there is no comment"]);
     }
     public function destroy(Request $request)
    {

        $comment = react::find($request->id);
        if (is_null($comment)) {
            return $this->sendError(' no comment found ');
        }
        $comment->delete();


        return $this->sendResponse(  'comment deleted successfully',new comment($comment));
    }


}
