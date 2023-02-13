<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class HRManagement extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    
    protected $table = "holidays";
    
    protected $fillable = [
        'holiday',
        'holiday_date',
        'holiday_category',
        'created_by',
        'updated_by'
    ];
}
