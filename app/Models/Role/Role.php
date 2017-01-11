<?php
/**
 * Created by PhpStorm.
 * User: benfoo
 * Date: 16/12/29
 * Time: 下午2:54
 */

namespace App\Models\Role;


use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole{

    protected $table = 'roles';

    protected $fillable = ['name','display_name','description'];

    public function Permission()
    {
        return $this->belongsToMany('App\Models\Role\Permission');
    }

    public function AdminUser(){

        return $this->belongsToMany('App\Models\Role\AdminUser');

    }

}