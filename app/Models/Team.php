<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name',
        'whatsapp',
        'project_id',
        'salary',
        'status',
        'notes'
    ];
    
    protected $casts = [
        'payment_date' => 'datetime'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
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