<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Contracts\Auth\MustVerifyEmail;

class LeaveForm extends Model
{
    use HasFactory;

    protected $table = "leaves";

    protected $fillable = [
        'first_name',
        'last_name',
        'employee_number',
        'department',
        'date_applied',
        'leave_type',
        'reason'
    ];
}