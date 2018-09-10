<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    protected $table = 'support';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id','due_date','duration',
        'description', 'send_email_notification', 'status',
        'deleted', 'access_data', 'project_url'
    ];
}
