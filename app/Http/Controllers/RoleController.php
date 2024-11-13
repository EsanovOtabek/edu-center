<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function getRoleDescription($role)
    {
        $r = Role::where('name', $role)->first();
        return $r->description;
    }

    public function getAuthMessage($role)
    {
        return $this->getRoleDescription($role) . ' bo\'lib tizimga kirdingiz!';
    }

    public function redirectRole($role)
    {
        return redirect(route($role));
    }

    public function hasRole($role)
    {
        return Role::where('name',$role)->exists();
    }
}
