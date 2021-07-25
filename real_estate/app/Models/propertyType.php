<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class propertyType extends Model
{
	protected $fillable = ['property_type_name'];
    use HasFactory;
}
