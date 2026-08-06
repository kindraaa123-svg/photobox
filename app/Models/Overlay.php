<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Overlay extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'image_path',
        'category_id',
        'description',
    ];

    /**
     * Get the category that owns the overlay design.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
