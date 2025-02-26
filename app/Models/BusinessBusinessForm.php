<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessBusinessForm extends Model
{
    use HasFactory;

    protected $table = 'business_business_form'; // Tên bảng

    protected $fillable = [
        'business_id',
        'business_form_id',
    ]; // Cho phép mass assignment

    /**
     * Quan hệ với model Business.
     */
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * Quan hệ với model BusinessForm.
     */
    public function businessForm()
    {
        return $this->belongsTo(BusinessForm::class);
    }
}
