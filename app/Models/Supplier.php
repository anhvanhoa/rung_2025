<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
    ];

    public function businesses()
    {
        return $this->belongsToMany(Business::class, 'business_suppliers');
    }
}
