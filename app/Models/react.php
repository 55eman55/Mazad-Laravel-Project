<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class react extends Model
{
    use HasFactory;
    protected $fillable = [
        'comment','user_id','product_id'
     ];
     public function usercomment()
     {
         return $this->belongsTo(User::class, 'user_id', 'id');
     }
    //  public function productcomment()
    //  {
    //      return $this->belongsTo(product::class, 'id', 'product_id');
    //  }
     public function products()
     {
         return $this->belongsTo(product::class, 'product_id', 'id');
     }

}
