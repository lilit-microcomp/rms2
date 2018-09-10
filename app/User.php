<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Actuallymab\LaravelComment\CanComment;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password', 'role_id', 'role_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'is_admin' => 'boolean',
        'is_developer' => 'boolean',
    ];

    public function isAdmin()
    {
        return $this->is_admin;
    }
    public function isDeveloper()
    {
        return $this->is_developer;
    }
}
