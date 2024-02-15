<?php

namespace App\Models\rbac;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model{
     const PERMISSION_MANAGE_USER = 'user.index';
     const PERMISSION_MANAGE_HOME = 'home';

     public static array $permissions = [
          self::PERMISSION_MANAGE_USER          => 'Update and View Users',
          self::PERMISSION_MANAGE_HOME          => 'view home page',
     ];

}