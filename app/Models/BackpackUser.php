<?php

namespace App\Models;

use App\Models\User;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Spatie\Permission\Traits\HasPermissions;

class BackpackUser extends User
{
    use CrudTrait, HasPermissions;

    protected $table = 'users';

    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->email;
    }
}
