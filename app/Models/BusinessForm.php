<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessForm extends Model
{
    use HasFactory;
    public function businesses()
    {
        return $this->belongsToMany(Business::class, 'business_business_form');
    }
}
