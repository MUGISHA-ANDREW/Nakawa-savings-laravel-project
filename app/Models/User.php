<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'username',
        'password',
        'next_of_kin_name',
        'next_of_kin_phone',
        'next_of_kin_relationship',
        'role',
        'account_balance'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'account_balance' => 'decimal:2',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isMember(): bool
    {
        return $this->role === 'member';
    }

    public function isTreasurer(): bool
    {
        return $this->role === 'treasurer';
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function deposits()
    {
        return $this->hasMany(Transaction::class)->where('type', 'deposit');
    }

    public function withdrawals()
    {
        return $this->hasMany(Transaction::class)->where('type', 'withdrawal');
    }

    public function pendingWithdrawals()
    {
        return $this->withdrawals()->where('status', 'pending');
    }

    public function completedTransactions()
    {
        return $this->transactions()->where('status', 'completed');
    }
}