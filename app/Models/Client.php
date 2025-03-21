<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'whatsapp',
        'address',
        'notes',
        'status',
        'company_name',
        'position',
        'website',
        'instagram',
        'source',
        'profile_image',
    ];

    protected $dates = [
        'last_contact',
        'last_project',
        'deleted_at'
    ];

    protected $casts = [
        'last_contact' => 'datetime',
        'last_project' => 'datetime',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function getActiveProjectsAttribute()
    {
        return $this->projects()->where('status', 'process')->count();
    }

    public function getTotalProjectsAttribute()
    {
        return $this->projects()->count();
    }

    public function getTotalPaymentsAttribute()
    {
        return $this->projects()->sum('price');
    }

    public function getTotalPaidAttribute()
    {
        return $this->projects()->withSum('payments', 'amount')->get()->sum('payments_sum_amount');
    }

    public function getFormattedWhatsappAttribute()
    {
        return preg_replace('/^0/', '+62', $this->whatsapp);
    }

    public function getProfileImageUrlAttribute()
    {
        if ($this->profile_image) {
            return asset('storage/' . $this->profile_image);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

    public function updateLastContact()
    {
        $this->update(['last_contact' => now()]);
    }

    public function updateLastProject()
    {
        $this->update(['last_project' => now()]);
    }

    public function getStatusColorClass()
    {
        return [
            'active' => 'bg-green-500/10 text-green-500',
            'inactive' => 'bg-gray-500/10 text-gray-500',
        ][$this->status] ?? 'bg-gray-500/10 text-gray-500';
    }
} 