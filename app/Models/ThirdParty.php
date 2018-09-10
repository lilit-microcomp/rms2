<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThirdParty extends Model
{
    protected $table = 'third_party';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'website','username','password','description',
    ];
}
