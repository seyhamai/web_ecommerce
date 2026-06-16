<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // 1. Allow mass assignment for your form
    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'description',
        'image',
        'is_active'
    ];

    /**
     * Get the parent category (Points UP)
     * Usage: $category->parent->name
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the subcategories (Points DOWN)
     * Usage: $category->children
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
