<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    
    protected $guarded = [];
    protected $hidden = ['password'];
    protected $primaryKey = 'customer_id';
}
