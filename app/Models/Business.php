<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    const TYPE_PROCESSING = "processing";
    const TYPE_MANUFACTRUE = "manufacture";

    protected $fillable = [
        'name',
        'business_registration',
        'tax_code',
        'annual_revenue', // doanh thu hàng năm
        'average_consumption', // tiêu thụ trung bình
        'workers_no_qual',
        'workers_deg',
        'female_workers',
        'male_workers',
        'longitude',
        'latitude',
        'business_type_id',
        'commune_code',
        'owner_id'
    ];

    public function owner()
    {
        return $this->belongsTo(People::class, 'owner_id');
    }

    public function businessType()
    {
        return $this->belongsTo(BusinessType::class, 'business_type_id');
    }

    public function commune()
    {
        return $this->belongsTo(Commune::class, 'commune_code', 'code');
    }

    public function businessForms()
    {
        return $this->belongsToMany(BusinessForm::class, 'business_business_form');
    }
    public function sources()
    {
        return $this->hasMany(BusinessSource::class);
    }
}
