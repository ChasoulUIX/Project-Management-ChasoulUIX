<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name',
        'whatsapp'
    ];
    
    protected $casts = [
        'payment_date' => 'datetime'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class)
                    ->withPivot('salary', 'status', 'payment_date', 'amount_paid', 'notes')
                    ->withTimestamps();
    }

    public function getStatusColorClass()
    {
        return [
            'unpaid' => 'bg-red-500/10 text-red-500',
            'paid' => 'bg-green-500/10 text-green-500',
        ][$this->status] ?? '';
    }

    public function getFormattedWhatsappAttribute()
    {
        return preg_replace('/^0/', '+62', $this->whatsapp);
    }
} 