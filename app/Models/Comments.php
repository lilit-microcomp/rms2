<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $table = 'comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text','type','status',
        'parent_id', 'user_id', 'user_name', 'type_page',
        'type_page_row_id',
    ];
}
