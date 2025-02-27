<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    use HasFactory;
    const TYPE_IRRIGATION = 'irrigation';
    const TYPE_NURSERY = 'nursery';
    protected $fillable = [
        'name',
        'type',
    ];
}
