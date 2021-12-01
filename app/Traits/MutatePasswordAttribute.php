<?php

namespace App\Traits;

trait MutatePasswordAttribute
{
    /**
     * Set password the attribute value.
     *
     * @param  string  $key
     * @return mixed
     */
    public function setPasswordAttribute($password)
    {
        if (!empty($password)) {
            $this->attributes['password'] = bcrypt($password);
        }
    }
}
