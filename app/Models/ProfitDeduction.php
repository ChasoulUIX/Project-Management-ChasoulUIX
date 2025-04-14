<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfitDeduction extends Model
{
    protected $fillable = [
        'amount',
        'description',
        'deduction_date'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'deduction_date' => 'date'
    ];
}
