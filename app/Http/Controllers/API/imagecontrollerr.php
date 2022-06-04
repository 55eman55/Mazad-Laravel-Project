<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Image;
class imagecontrollerr extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            //'name' => 'required',
            'image'=>'required',
            ]);
            if($request->hasFile('image'))
            {
            $allowedfileExtension=['pdf','jpg','png','docx'];
            $files = $request->file('image');
            foreach($files as $file){
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $check=in_array($extension,$allowedfileExtension);
            //dd($check);
            if($check)
            {
            $items= Item::create($request->all());
            foreach ($request->image as $image) {
            $filename = $photo->store('image');
            ItemDetail::create([
            'item_id' => $items->id,
            'filename' => $filename
            ]);


        }}
    }}

}
}
