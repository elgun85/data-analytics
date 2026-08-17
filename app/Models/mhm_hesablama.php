<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class mhm_hesablama extends Model
{
    protected $fillable = [
        'hesab',
        'telefon',
        'summa',
        'abonent',
        'kod'

    ];



}
