<?php

namespace App\Models\Role;

use Illuminate\Database\Eloquent\Model;

class MenuPermission extends Model
{
    protected $table     = 'menu_permission';

    protected $fillable  = ['menu_id','permission_id','none_menu_item_id','permission_type'];
}
