<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    //use Commentable;

    protected $canBeRated = true;
    protected $table = 'projects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id','due_date','total_budget',
        'description', 'descriptive_title', 'project_url',
        'send_email_notification', 'name', 'user_id', 'status',
        'project_url_test', 'access_data',
    ];
}
