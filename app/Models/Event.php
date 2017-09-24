<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

    protected $fillable = [
        'title', 'duration', 'type'
    ];

    protected $guarded = ['id'];

    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
