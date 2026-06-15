<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasShortId;

class Role extends Model
{
    use HasShortId;

    protected $fillable = [
        'name',
    ];

    protected $hidden = [
        'id',
    ];


    public function users()
    {
        return $this->hasMany(User::class);
    }
}
