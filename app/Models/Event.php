<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed date
 */

class Event extends Model
{
    protected $table = 'events';

    protected $fillable = [
        'title', 'duration', 'type', 'date', 'user_id',
    ];

    protected $guarded = ['id'];

    protected $hidden = [
        'created_at', 'updated_at', 'date'
    ];

    protected $appends  = [
        'event_date',
    ];

    // Custom attributes -----------------------------------------------------------------------------------------------
    public function getEventDateAttribute() {
        return Carbon::parse($this->date)->toDateString();
    }
}
