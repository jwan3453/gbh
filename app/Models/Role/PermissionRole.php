<?php
/**
 * Created by PhpStorm.
 * User: benfoo
 * Date: 17/1/3
 * Time: 下午5:55
 */

namespace App\Models\Role;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model {

    protected $table = 'permission_role';

    protected $fillable = ['permission_id','role_id'];


}