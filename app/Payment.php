<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'month', 'year', 'salaries_total', 'salaries_payment_day', 'bonus_total', 'bonus_payment_day',
    ];

    // disable timestamps
    public $timestamps = false;

}
