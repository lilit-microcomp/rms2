<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersTasks extends Model
{
    protected $table = 'users_tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'developer_id', 'team_lead_id', 'task_id', 'status'
    ];
}
