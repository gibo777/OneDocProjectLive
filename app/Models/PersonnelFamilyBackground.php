<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonnelFamilyBackground extends Model
{
    use HasFactory;

    protected $table = "family_background";
  
    protected $fillable = [
    	'employee_id',
		'fb_name',
		'fb_birthdate',
		'fb_relationship',
		'fb_address',
		'fb_contact',
		'fb_occupation',
		'fb_company_name',
		'fb_company_address',
		'fb_company_contact',
		'is_tax_dependent',
		'is_sss_beneficiary',
		'is_phic_beneficiary',
		'can_be_notified',
		'is_deleted',
		'deleted_by',
		'deleted_at',
		'created_by',
		'updated_by',
    ];
}
