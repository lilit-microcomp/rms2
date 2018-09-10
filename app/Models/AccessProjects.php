<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessProjects extends Model
{
    protected $table = 'access_projects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_id','data',
    ];
}
//php artisan make:model ThirdParty