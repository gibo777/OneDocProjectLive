<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offices extends Model
{
    use HasFactory;

    protected $table = "departments";
    
    protected $fillable = [
        'office_code',
        'office_country',
        'office_province',
        'office_city',
        'office_address',
        'office_zipcode',
        'office_tin',
        'office_contact',
        'created_by',
        'updated_by'
    ];
}
