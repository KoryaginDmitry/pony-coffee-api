<?php

namespace App\Support\Traits;

trait UserRoleTrait
{
    /**
     * Static method get role user
     *
     * @return string
     */
    public static function staticGetRole() : string
    {
        $role = auth()->user()?->role->name;

        if (!$role) {
            $role = 'guest';
        }

        return $role;
    }

    /**
     * Get auth user role
     *
     * @return string
     */
    public function getRole() : string
    {
        return $this->role->name;
    }

    /**
     * Checking if a user is an administrator
     *
     * @return bool
     */
    public function isAdmin() : bool
    {
        return $this->role->name === 'admin';
    }

    /**
     * Checking if the user is a regular user
     *
     * @return bool
     */
    public function isUser() : bool
    {
        return $this->role->name === 'user';
    }

    /**
     * Checking if the user is a barista
     *
     * @return bool
     */
    public function isBarista() : bool
    {
        return $this->role->name === 'barista';
    }
}
