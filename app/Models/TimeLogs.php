<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Contracts\Auth\MustVerifyEmail;

class TimeLogs extends Model
{
    use HasFactory;

    protected $table = "time_logs";

    protected $fillable = [
        'employee_id',
        'profile_photo_path',
        'time_in',
        'time_out',
        'ip_address',
        'latitude',
        'longitude',
        'country_name',
        'country_code',
        'region_name',
        'region_code',
        'city_name',
        'zip_code',
        'created_at',
        'updated_at'
    ];
}
