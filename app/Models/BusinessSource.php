<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessSource extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'source_id'
    ];

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id');
    }
}
