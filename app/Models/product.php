<?php

namespace App\Models;

use App\Http\Resources\user;
use App\Models\User as ModelsUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    protected $fillable = [
       'p_name',
        'description',
        'num_bids',
        'deposite',
        'old_price',
        'new_price',
        'start_date',
        'end_date',
        'location',
        'user_id',
        'cat_id'
    ];
    protected $table = 'products';

   /* public function images()
    {
     return $this->hasMany('App\Models\image', 'p_id');
    }*/
    public function productImages()
    {
        return $this->hasMany(image::class,'p_id','id');
    }
    public function users()
    {
        return $this->belongsToMany(ModelsUser::class, 'user_products',  'product_id','user_id');
    }
    public function likess()
    {
        return $this->hasMany(like::class,'p_id','id');
    }
    public function comment()
    {
        return $this->hasMany(react::class,'product_id','id');
    }

}


