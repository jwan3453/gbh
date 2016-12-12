<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Union extends Model
{
    protected $table = 'Union';

    protected $fillable = ['hotel_name','hotel_address','hotel_number','hotel_person','person_number','person_email','remarks'];


}
