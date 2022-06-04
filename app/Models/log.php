<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class log extends Model
{
    use HasFactory;

    protected $fillable = [
        'id','p_id',
    ];

    public function user(){

        return $this ->hasMany('App\Models\User','id','logs_id');
    }
}
