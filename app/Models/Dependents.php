<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dependents extends Model
{
    use HasFactory;
    protected $table = 'dependents';

    protected $fillable = [
        'id',
        'employee_id',
        'dependent_name',
        'dependent_birthdate',
        'dependent_age',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        
    ];
}
