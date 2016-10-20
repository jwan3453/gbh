<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Category extends Model
{
    protected $table = 'category';

    public function hotels()
    {
        return $this->belongsToMany('App\Models\Hotel');
    }
}
