<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessBreed extends Model
{
    use HasFactory;

    protected $fillable = ["business_id", "breed_id"];

    
}
