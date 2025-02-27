<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Garden extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'acreage',
        'type',
    ];

    static public function getValueType($type)
    {
        switch ($type) {
            case "fixed":
                return "Cố định";
            case "dynamic":
                return "Linh động";
            default:
                return "Không xác định";
        }
    }
}
