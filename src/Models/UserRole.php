<?php

namespace BRamalho\LaravelUserPermissions\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    /** @var array $fillable */
    protected $fillable = ['name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permissions()
    {
        return $this->hasMany(UserPermission::class, 'user_role_id', 'id');
    }

    /**
     * @param string $module
     * @param string $action
     * @return bool
     */
    public function hasPermission($module, $action)
    {
        foreach ($this->permissions as $item) {
            if ($item->module == $module && $item->action == $action) {
                return true;
            }
        }
        return false;
    }
}
