<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessSupplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'supplier_id',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
