<?php

namespace App\Models\Role;

use Illuminate\Support\Facades\Session;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class AdminUser extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword,EntrustUserTrait{
        EntrustUserTrait::can as may;
        Authorizable::can insteadof EntrustUserTrait;
    }

    protected $table      = 'admin_user';

    protected $primaryKey = 'user_id';

    protected $fillable   = ['username', 'password','truename','mobile','remarks','hotel_id','position'];

    public function Role(){

        return $this->belongsTo('App\Models\Role\Role');

    }


}


?>