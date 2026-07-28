<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'description',
        'image',
        'is_active'
    ];

     public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    public function getFullPathAttribute()
    {
        $names = [];
        $category = $this;
        
        while ($category) {
            $names[] = $category->name;
            $category = $category->parent;
        }
        
        return implode(' > ', array_reverse($names));
    }
}
