<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\views;
use App\Models\category;
use App\Models\User;
use App\Models\product;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Validator;


class searchController extends BaseController
{
    public function search(Request $request)
    {
        if ($request->kind) {
            $categores = category::where('kind', 'like', '%' . $request->kind . '%')->get(['kind', 'category_images']);
            return $this->sendResponse('category found successfully', $categores, '');

            if (is_null($categores)) {
                return $this->sendError('product not found ');
            }
        } elseif ($request->name) {
            $user = User::where('name', 'like', '%' . $request->name . '%')->get(['name', 'profile_picture']);

            return $this->sendResponse('user found successfully', $user, '');

            if (is_null($user)) {
                return $this->sendError('user not found ');
            }
        }
        elseif($request->p_name){

            $product = product::with('productImages')->where('p_name', 'like', '%'. $request->p_name.'%')->get();
             return $this->sendResponse('product found successfully' ,$product,'');

             if (is_null($product)) {
                return $this->sendError('product not found ');
            }
        }else
        {
            return $this->sendError('Make Sure To Write Down Anything For Search');
        }
    }
}
