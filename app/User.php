<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'user_name', 'email', 'password', 'phone_number',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function addresses()
    {
    	return $this->hasMany('\App\Address');
    }

    public function permission()
    {
        return $this->hasOne('\App\Permission');
    }

    public function isEmployee()
    {
        return $this->permission()->exists();
    }

    public function hasPermission($permissionName)
    {
        if(!$this->isEmployee()) {
            return false;
        }

        $permission = $this->permission()->first()->hasPermissions();
        if(in_array($permissionName, $permission)){
            return true;
        }

        return false;
    }

    public function permissions()
    {
        if(!$this->isEmployee()) return [];

        return $this->permission()->first()->hasPermissions();
    }

    public static function usersWithPermissions($permissions, $query = false)
    {
        if(!$query) $query = self::query();
        $query = $query->whereHas('permission', function($q) use ($permissions) {
            foreach($permissions as $permission) {
                $q->where($permission, 1);
            }
        });

        return $query;
    }

    public function orders()
    {
        return $this->hasMany('\App\Order');
    }
}
