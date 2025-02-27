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
        "sell_trees_qty", // số lượng cây bán ra cây lâm nghiệp
        "type", // loại hình kinh doanh
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

    public function primaryTrees()
    {
        return $this->belongsToMany(Breed::class, 'business_breeds');
    }

    public function irrigation()
    {
        return $this->belongsToMany(Technology::class, 'business_technologies')->where('type', Technology::TYPE_IRRIGATION)->limit(1);
    }

    public function nurseries()
    {
        return $this->belongsToMany(Technology::class, 'business_technologies')->where('type', Technology::TYPE_NURSERY);
    }

    public function garden()
    {
        return $this->hasOne(Garden::class, 'business_id');
    }

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'business_suppliers');
    }
}
