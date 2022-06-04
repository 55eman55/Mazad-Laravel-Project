<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notification extends Model
{
    use HasFactory;
    protected $fillable = [
       'date','data'
    ];
    public function Users()

    {
        return $this->belongsToMany(User::class, 'user_notifications', 'notification_id','user_id');
    }
}
