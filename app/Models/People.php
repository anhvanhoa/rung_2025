<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    use HasFactory;
    protected $table = 'people'; // Tên bảng trong database
    protected $fillable = [
        'name',
        'phone',
        'gender',
        'date_of_birth',
    ]; // Cho phép mass assignment

    protected $casts = [
        'date_of_birth' => 'date',
    ]; // Chuyển date_of_birth thành kiểu Date

    /**
     * Lấy danh sách businesses mà người này sở hữu (One-to-Many).
     */
    public function businesses()
    {
        return $this->hasMany(Business::class, 'owner_id');
    }
}
