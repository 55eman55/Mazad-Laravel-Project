<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\react;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Resources\comment;

class commentController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required',

        ]);

        $f = new react();
        $f->comment = $request->comment;

        react::create([
         'product_id' => $request->product_id,
          'user_id' => $request->user_id

        ]);

        $f->save();
        return $this->returnSuccessMessage('success');
    }
}
