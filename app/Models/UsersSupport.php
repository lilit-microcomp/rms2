<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersSupport extends Model
{
    protected $table = 'users_support';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'developer_id', 'team_lead_id', 'support_id', 'status', 'pm_id',
    ];
}
