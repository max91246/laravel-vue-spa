<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectInfo extends Model
{
    protected $fillable = [
        'big_project_id',
        'project_id',
        'size_id',
        'style_id',
        'num',
        'admin',
        'amount'
    ];
}
