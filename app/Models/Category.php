<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
    ];

    /**
     * Get the overlays for the category.
     */
    public function overlays()
    {
        return $this->hasMany(Overlay::class);
    }
}
