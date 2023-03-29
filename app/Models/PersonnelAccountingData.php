<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class PersonnelAccountingData extends Model
{
    use HasFactory;

    protected $table = "accounting_data";
  
    protected $fillable = [
        'employee_id', 
        'sss_number', 
        'phic_number',
        'pagibig_number',
        'tin_number',
        'tax_status',
        'health_card_number',
        'drivers_license',
        'passport_number',
        'passport_expiry',
        'prc',
    ];
}
