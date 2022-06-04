<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\like;
use App\Models\Product as productmodel;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller

    { use GeneralTrait;
        public function makeLike(Request $request){
            try{
                $check_product =productmodel::find($request->product_id);
                if(! $check_product){
                    return $this->returnError(202, 'product not founded');
                }
                Like::create([
                    'product_id' => $request->product_id,
                    'user_id' => Auth()->user()->id
                ]);
                return $this->returnSuccessMessage('success');
            }catch(\Exception $e){
                return $this->returnError(201, $e->getMessage());
            }
        }

        public function makeDislike(Request $request){
            try{
                $like = like::find($request->id);
                if(! $like){
                    return $this->returnError(202, 'product not founded');
                }
                $like->delete();
                return $this->returnSuccessMessage('success');
            }catch(\Exception $e){
                return $this->returnError(201, $e->getMessage());
            }
        }

        public function getMyFavorite(Request $request){
            try{
                $favorites = Like::with('product.productImages')->where('user_id',Auth()->user()->id)->get();
                return $this->returnData('data', $favorites);
            }catch(\Exception $e){
                return $this->returnError(201, $e->getMessage());
            }
        }
    }
