<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests , GeneralTrait;
    public function uploadImage(Request $request){
        try{
            if(! $request->hasFile('file')){
                return $this->returnError(202, 'file is required');
            }
            $response = cloudinary()->upload($request->file('file')->getRealPath())->getSecurePath();
            return $response;
        }catch(\Exception $e){
            return $this->returnError(201, $e->getMessage());
        }
    }
}
