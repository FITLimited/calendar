<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

/**
 * @property string password
 * @property mixed name
 * @property mixed email
 * @property mixed birthday
 * @property mixed working_from
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'birthday', 'password', 'working_from'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'role_id', 'created_at', 'updated_at', 'birthday', 'working_from'
    ];

    protected $appends  = [
        'user_birthday', 'user_working_from'
    ];

    public function role()
    {
        return $this->hasOne(UserRole::class, 'id', 'role_id');
    }

    // Custom attributes -----------------------------------------------------------------------------------------------
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function getUserBirthdayAttribute() {
        return Carbon::parse($this->birthday)->toDateString();
    }

    public function getUserWorkingFromAttribute() {
        return Carbon::parse($this->working_from)->toDateString();
    }
}
