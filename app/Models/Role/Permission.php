<?php
/**
 * Created by PhpStorm.
 * User: benfoo
 * Date: 17/1/3
 * Time: 下午4:58
 */
namespace App\Models\Role;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission {

    protected $table = 'permissions';

    protected $fillable = ['name','display_name','description','route','permission_level','parent_id','menu_id','menu_type'];

    public function Role()
    {
        return $this->belongsToMany('App\Models\Role\Role');
    }

    public function Group(){

        return $this->belongsToMany('App\Models\Role\Group');

    }
}