<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Point extends Model 
{
   
    protected $primaryKey = 'user_id';
    protected $table = 'points';
    protected $fillable = [
        'user_fullname', 'user_point'
    ];
    
}
