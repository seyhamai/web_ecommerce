<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// REMOVE THIS: use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
use App\Traits\HasShortId; // 1. Import your new trait

class User extends Authenticatable
{
    // 2. Swap HasUlids for HasShortId
    use HasFactory, Notifiable, HasShortId, SoftDeletes;

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'id',
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // 3. DELETE the uniqueIds() method! You don't need it anymore.

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
