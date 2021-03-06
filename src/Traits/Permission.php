<?php

namespace BRamalho\LaravelUserPermissions\Traits;

use BRamalho\LaravelUserPermissions\Models\UserPermission;
use BRamalho\LaravelUserPermissions\Models\UserRole;

trait Permission
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(UserRole::class)->withTimestamps();
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasRole($name)
    {
        foreach ($this->roles as $role) {
            if ($role->name === $name) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function hasRoleId($id)
    {
        foreach ($this->roles as $role) {
            if ($role->id === $id) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param UserRole $role
     */
    public function assignRole($role)
    {
        $this->roles()->attach($role);
    }

    /**
     * @param UserRole $role
     */
    public function removeRole($role)
    {
        $this->roles()->detach($role);
    }

    /**
     * @param $module
     * @param $action
     * @return bool
     */
    public function hasPermission($module, $action)
    {
        if ($this->hasRole('SuperAdmin') || $this->hasRole('Super Admin')) {
            return true;
        }

        foreach ($this->roles as $role) {
            $permission = UserPermission::where('user_role_id', $role->id)
                ->where('module', $module)
                ->where('action', $action)
                ->first();

            if ($permission) {
                return true;
            }
        }

        return false;
    }
}
