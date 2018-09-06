<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    //
    protected $fillable = [
        'level',
        'user_id',
        'action',
        'table_name',
        'description',
        'created_at',
        'updated_at'
    ];
}
