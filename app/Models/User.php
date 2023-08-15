<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'first_name', 
        'last_name', 
        'middle_name',
        'suffix',
        'employee_id', 
        'position', 
        'department', 
        'office',
        'employment_status',
        'date_hired',
        'weekly_schedule',
        'gender',
        'role_type',
        'email', 
        'password',
        'remember_token',
        'expires_at',
        'created_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthdate' => 'date:m/d/Y',
        'date_hired' => 'date:F d, Y',
        // 'status' => 'string:upper',
        // 'date_from' => 'date:m/d/Y',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    
    /**
     * @return string
     */
    public function getProfilePhotoUrlAttribute()
    {
        // You can add any of the gravatar supported options to this array.
        // See https://gravatar.com/site/implement/images/
        $config = [
            'default' => $this->defaultProfilePhotoUrl(),
            'size' => '200' // use 200px by 200px image
        ];
        $defaultPhoto = 'default-photo.png';

        // return 'https://www.gravatar.com/avatar/'.md5($this->email).'?'.http_build_query($config);
        if ($this->profile_photo_path) {
            return asset('/storage/'.$this->profile_photo_path);
        } else {
            switch ($this->gender) {
                case 'M':
                    $defaultPhoto='default-formal-male.png';
                    break;
                case 'F':
                    $defaultPhoto='default-female.png';
                    break;
                case 'NB':
                    $defaultPhoto='default-photo.png';
                    break;
            }

            return asset('/storage/profile-photos/'.$defaultPhoto);
        }
    }

    /**
     * @return string
     */
    public function defaultProfilePhotoUrl()
    {
        return 'https://ui-avatars.com/api/'. implode('/', [

            //IMPORTANT: Do not change this order
            urlencode($this->name), // name
            200, // image size
            'EBF4FF', // background color
            '7F9CF5', // font color
        ]);
    }
}
