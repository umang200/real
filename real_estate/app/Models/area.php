<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class area extends Model
{
	protected $fillable = ['city_id','area_name'];
    use HasFactory;
}
