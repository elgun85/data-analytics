<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MhmDovriyye extends Model
{
    protected $table = 'mhm_dovriyyes';

    protected $fillable = [
        'service_code',
        'phone',
        'order_number',
        'name',
        'vat_status',
        'organization_type',
        'category',
        'opening_balance',
        'payment_amount',
        'accrual_amount',
        'storno_amount',
        'closing_balance'
    ];
}
