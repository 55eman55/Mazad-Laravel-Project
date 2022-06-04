<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class views extends Model
{
    use HasFactory;
    public $table = "search";

    public function productImages()
    {
        return $this->hasMany(image::class,'id');
    }
}
