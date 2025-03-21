<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'price', 'notes', 'status'];

    const STATUS_PENDING = 'pending';
    const STATUS_PROCESS = 'process';
    const STATUS_CANCEL = 'cancel';
    const STATUS_SUCCESS = 'success';

    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_PROCESS => 'Process',
            self::STATUS_CANCEL => 'Cancel',
            self::STATUS_SUCCESS => 'Success',
        ];
    }

    public function getStatusColorClass()
    {
        return [
            self::STATUS_PENDING => 'bg-yellow-500/10 text-yellow-500',
            self::STATUS_PROCESS => 'bg-blue-500/10 text-blue-500',
            self::STATUS_CANCEL => 'bg-red-500/10 text-red-500',
            self::STATUS_SUCCESS => 'bg-green-500/10 text-green-500',
        ][$this->status] ?? '';
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getTotalPaidAttribute()
    {
        return $this->payments->sum('amount');
    }

    public function getRemainingBalanceAttribute()
    {
        return $this->price - $this->total_paid;
    }

    public function getPaymentProgressAttribute()
    {
        if ($this->price <= 0) return 0;
        return ($this->total_paid / $this->price) * 100;
    }
} 