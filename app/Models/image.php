<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class image extends Model
{
    use HasFactory;
    protected $fillable = [

        'p_id',
        'path'
     ];
    //  public function product()
    //  {
    //    return $this->belongsTo('App\Models\Product', 'p_id');
    //  }
     public function products()
     {
         return $this->belongsTo(product::class, 'id', 'p_id');
     }

     public function views()
     {
         return $this->belongsTo(product::class, 'id', 'p_id');
     }

}
