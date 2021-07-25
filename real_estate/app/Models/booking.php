<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class booking extends Model
{
	protected $fillable = ['seller_id','buyer_id','propety_id','message','mobile_no'];
    use HasFactory;
}
