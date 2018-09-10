<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersProjects extends Model
{
    protected $table = 'users_projects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','project_id',
    ];
}
