<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MhmUsers extends Model
{
    protected $table = 'mhm_users';

    protected $fillable = [
        'phone',
        'company_account',
        'name',
        'street',
        'address'
    ];
}
