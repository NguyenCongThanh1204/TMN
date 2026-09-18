<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leader extends Model
{
    protected $table = 'leaders';

    protected $fillable = [
        'level_id',
        'name',
        'title',
        'image',
        'bio',
        'email',
        'position_order',
    ];
}