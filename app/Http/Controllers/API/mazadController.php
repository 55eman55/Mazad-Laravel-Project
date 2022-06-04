<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mazad;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Product as ProductResource;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\mazad as ResourcesMazad;

class mazadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = mazad::all();
        return $this->sendResponse(ResourcesMazad::collection($products), 'All products sent');
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input =$request->all;
        $validator= Validator::make($input ,[
            'name' => 'required',
        'detials' => 'required',
        'price' => 'required'

        ]);

        if ($validator->fails()) {
            return $this->sendError('Please validate error' ,$validator->errors() );
        }
        $mazad = Mazad::create($input);
        return $this->sendResponse( new ResourcesMazad( $mazad) ,'Product created successfully' );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mazad = Mazad::find($id);
        if (is_null($mazad)) {
            return $this->sendError('Product not found');
        }
        return $this->sendResponse( new ResourcesMazad( $mazad) ,'Product found successfully' );

    }
    public function update(Request $request, Mazad $mazad)
    {
        $input =$request->all;
        $validator= Validator::make($input ,[
            'name' => 'required',
        'detials' => 'required',
        'price' => 'required'

        ]);

        if ($validator->fails()) {
            return $this->sendError('Please validate error' ,$validator->errors() );
        }
        $mazad->name = $input['name'];
        $mazad->detials = $input['detials'];
        $mazad->price = $input['price'];
        return $this->sendResponse( new ResourcesMazad( $mazad) ,'Product Updated successfully' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mazad $mazad)
    {
        $mazad->delete() ;
        return $this->sendResponse( new ResourcesMazad( $mazad) ,'Product Deleted successfully' );


    }
}
