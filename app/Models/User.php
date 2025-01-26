<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;
class User extends Authenticatable
{
    use HasApiTokens,HasFactory,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        // 'cdap_user_id',
        // 'is_cdap_user',
        // 'role_id',
        // 'office_id',
        // 'doptor_office_id',
        // 'doptor_user_flag',
        // 'doptor_user_active',
        // 'peshkar_active',
        // 'court_id',
        // 'mobile_no',
        // 'profile_image',
        // 'signature',
        // 'citizen_id',
        // 'citizen_nid',
        // 'otp',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    
    public function role() {
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function office() {
        return $this->belongsTo(Office::class, 'office_id');
    }
    public function court() {
        return $this->belongsTo(Court::class, 'office_id');
    }

}
