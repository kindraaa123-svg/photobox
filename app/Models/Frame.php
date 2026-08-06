<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Frame extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'layout_type',
        'bg_color',
        'overlay_image',
        'slots',
        'is_public'
    ];

    protected $casts = [
        'slots' => 'array',
        'is_public' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creations()
    {
        return $this->hasMany(Creation::class);
    }
}
