<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $table = 'hotel';

    public function Categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }
}
