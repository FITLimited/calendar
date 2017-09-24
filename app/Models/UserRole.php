<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    public $timestamps = false;
    protected $table = 'user_roles';
    protected $fillable = ['name'];
    protected $guarded = ['id'];

    const ADMIN = 'Admin';
    const USER  = 'User';

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
