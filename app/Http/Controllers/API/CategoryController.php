<?php

namespace App\Http\Controllers\API;

use App\Models\category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\category as productCategory;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Traits\GeneralTrait;


class CategoryController extends BaseController
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categores = category::all();
        return $this->sendResponse(
            productCategory::collection($categores),
            'all categories sent'
        );
    }

    public function searchcategory(Request $request)
    {
        $categores= category::where('kind', 'like', '%'. $request->kind.'%')->get();
         return $this->sendResponse($categores,'' ,'category found successfully');

         if (is_null($categores)) {
            return $this->sendError('product not found ');
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'category_images' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'kind' => 'required',
            $path = $this->saveImage($request->category_images, 'category_images'),

        ]);

        $category = new category();
        $category->kind = $request->kind;
        $category->category_images = $path;


        $category->save();

        return $this->sendResponse(new productCategory($category), 'Categories created successfully');
    }


    public function show(Request $request)
    {
        $categores = category::find($request->id);

        if (is_null($categores)) {
            return $this->sendError('product not found ');
        }
        return $this->sendResponse(new productCategory($categores), 'Category found successfully');
    }


    // public function edit(category $category)
    // {
    //     //
    // }

    public function update(Request $request)
    {

        if ($request->has('kind')) {
            $rules = [
                'kind' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {


                return response()->json(['error' => $validator->errors()]);
            }
        }

        $request->validate([
            'category_images' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        $categores = category::find($request->id);
        $path = $this->saveImage($request->category_images, 'category_images');
        $categores->category_images = $path;
        $categores->update([
            'kind' => $request->kind ?? $categores->kind,
        ]);
        return $this->sendResponse(new productCategory($categores), 'category updated successfully');
    }



    public function destroy(Request $request)
    {

        $categores = category::find($request->id);
        if (is_null($categores)) {
            return $this->sendError('category not found ');
        }
        $categores->delete();
        return $this->sendResponse(new productCategory($categores), 'product deleted successfully');
    }
}
