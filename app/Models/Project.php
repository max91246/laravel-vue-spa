<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'big_id',
        'name',
        'admin',
        'img'
    ];


    public function bigproject()
    {
        return $this->hasOne('App\Models\BigProject' , 'id' , 'big_id');
    }

    public function project_info()
    {
        return $this->hasMany('App\Models\ProjectInfo' , 'id' , 'big_id');
    }

}
