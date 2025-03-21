<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['project_id', 'amount', 'payment_method', 'notes', 'payment_date'];
    protected $dates = ['payment_date'];
    protected $casts = [
        'payment_date' => 'datetime'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
} 