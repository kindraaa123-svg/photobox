<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Creation extends Model
{
    protected $fillable = [
        'user_id',
        'frame_id',
        'image_path',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function frame()
    {
        return $this->belongsTo(Frame::class);
    }
}
