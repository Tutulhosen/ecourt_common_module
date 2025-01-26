<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class ParentOffice extends Authenticatable
{
    protected $table = 'parent_office';
    protected $fillable = [
        'org_email', 'password', // Add other fields as needed
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
}

