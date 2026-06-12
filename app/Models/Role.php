<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Role extends Model
{
    use HasUlids;

    protected $fillable = [
        'name',
    ];

    protected $hidden = [
        'id',
    ];

    public function uniqueIds(): array
    {
        return ['public_id'];
    }

    public function getRouteKeyName(): string
    {
        return 'public_id';
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
