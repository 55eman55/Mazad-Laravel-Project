<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Models\product;
use App\Models\image;
use App\Models\like;

use Illuminate\Support\Facades\Validator;
use App\Http\Resources\product as productResource;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Traits\GeneralTrait;

class ProductController extends BaseController
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = product::all();
        return $this->sendResponse(
            productResource::collection($products),
            'all products sent'
        );
    }
    public function getProducts(Request $request)
    {
        try {

            $product = Product::with('users')->get();
            return $this->returnData('data', $product);
        } catch (\Exception $e) {
            return $this->returnError(201, $e->getMessage());
        }
    }
    public function search(Request $request)
    {
         $validator = Validator::make($request->all(), [

            'p_name' => 'required',

        ]);

        if ($validator->fails()) {


            return response()->json(['error' => $validator->errors()]);
        }
        $product = product::with('productImages')->where('p_name', 'like', '%'. $request->p_name.'%')->get();
         return $this->sendResponse($product,'' ,'product found successfully');

         if (is_null($product)) {
            return $this->sendError('product not found ');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'p_name' => 'required',
            'description' => 'required',
            'num_bids' => 'required',
            'deposite' => 'required',
            'old_price' => 'required',
            'new_price' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'location' => 'required',
            'user_id' => 'required',
            'cat_id' => 'required',
            'product_images' => 'required|array',

        ]);

        $product = new product;
        $product->p_name = $request->p_name;
        $product->description = $request->description;
        $product->num_bids = $request->num_bids;
        $product->deposite = $request->deposite;
        $product->old_price = $request->old_price;
        $product->new_price = $request->new_price;
        $product->start_date = $request->start_date;
        $product->end_date = $request->end_date;
        $product->location = $request->location;
        $product->user_id = $request->user_id;
        $product->cat_id = $request->cat_id;

        $product_id = Product::insertGetId([
            'user_id' => $request->user_id,
            'p_name' => $request->p_name,
            'description' => $request->description,
            'num_bids' => $request->num_bids,
            'deposite' => $request->deposite,
            'old_price' => $request->old_price,
            'new_price' => $request->new_price,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'location' => $request->location,
            'cat_id' => $request->cat_id,

        ]);

        foreach ($request->product_images as $product_image) {
            $path = '';
            if (!is_file($product_image['image'])) {
                return $this->sendError(202, 'data type is required, is only files');
            }
            $path = $this->saveImage($product_image['image'], 'products');
            image::create([
                'p_id' => $product_id,
                'path' => $path
            ]);
        }



        $product->save();

        return $this->sendResponse(new productResource($product), 'product insereted successfully');
    }

    public function show(Request $request)
    {

        $product = product::with('productImages','comment')->find($request->id);

        if (is_null($product)) {
            return $this->sendError('product not found ');
        }


       return $this->returnData('data', $product);
    }



    public function updateproduct(Request $request)
    {

        if ($request->has('p_name')) {
            $rules = [
                'p_name' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {


                return response()->json(['error' => $validator->errors()]);
            }
        }

        if ($request->has('description')) {
            $rules = [
                'description' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {


                return response()->json(['error' => $validator->errors()]);
            }
        }

        if ($request->has('num_bids')) {
            $rules = [
                'num_bids' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {


                return response()->json(['error' => $validator->errors()]);
            }
        }
        if ($request->has('deposite')) {
            $rules = [
                'deposite' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {


                return response()->json(['error' => $validator->errors()]);
            }
        }
        if ($request->has('old_price')) {
            $rules = [
                'old_price' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {


                return response()->json(['error' => $validator->errors()]);
            }
        }
        if ($request->has('new_price')) {
            $rules = [
                'new_price' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {


                return response()->json(['error' => $validator->errors()]);
            }
        }
        if ($request->has('start_date')) {
            $rules = [
                'start_date' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {


                return response()->json(['error' => $validator->errors()]);
            }
        }
        if ($request->has('end_date')) {
            $rules = [
                'end_date' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {


                return response()->json(['error' => $validator->errors()]);
            }
        }
        if ($request->has('location')) {
            $rules = [
                'location' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {


                return response()->json(['error' => $validator->errors()]);
            }
        }
        $product = product::find($request->id);
        $product->productImages()->delete();
        foreach ($request->product_images as $product_image) {
            $path = '';
            if (!is_file($product_image['image'])) {
                $path = $product_image['image'];
            } else {
                $path = $this->saveImage($product_image['image'], 'products');
                // or if you use cloudinary system
                // $path = cloudinary()->upload($product_image['image']->getRealPath())->getSecurePath();
            }
            image::create([
                'p_id' => $product['id'],
                'path' => $path
            ]);
        }




        $product->update([


            'p_name' => $request->p_name ?? $product->p_name,
            'description' => $request->description ?? $product->description,
            'num_bids' => $request->num_bids ?? $product->num_bids,
            'deposite' => $request->deposite ?? $product->deposite,
            'old_price' => $request->old_price ?? $product->old_price,
            'new_price' => $request->new_price ?? $product->new_price,
            'start_date' => $request->start_date ?? $product->start_date,
            'end_date' => $request->end_date ?? $product->end_date,
            'location' => $request->location ?? $product->location,


        ]);
        return response()->json(['status' => 'true', 'message' => 'update_product', 'data' => $product]);
    }

    public function destroy(Request $request)
    {

        $product = product::find($request->id);
        if (is_null($product)) {
            return $this->sendError('product not found ');
        }
        $product->delete();


        return $this->sendResponse(new ProductResource($product), 'Product deleted successfully');
    }

}
