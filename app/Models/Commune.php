<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    use HasFactory;

    protected $table = "communes";
    protected $fillable = ["code", "name", "longitude", "latitude", "district_code"];

    public function district()
    {
        return $this->belongsTo(District::class, "district_code", "code");
    }

}
