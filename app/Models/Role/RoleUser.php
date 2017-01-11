<?php
/**
 * Created by PhpStorm.
 * User: benfoo
 * Date: 17/1/4
 * Time: 下午3:28
 */

namespace App\Models\Role;



use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model {

    protected $table = 'role_user';

    protected $fillable = ['user_id','role_id'];


}