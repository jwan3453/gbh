<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class  MarkingRecords extends Model
{
    protected $table = 'marking_records';

    public function setTotalPointsAttribute()
    {
        $this->attributes['totalPoints'] = 100;
    }

    public function scopeCreatedAt($query)
    {
        $query->where('created_at','<=',Carbon::now());
    }


}
