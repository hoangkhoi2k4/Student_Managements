<?php

namespace App\Repositories;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleRepository extends BaseRepository
{
    public function getModel()
    {
        return \Spatie\Permission\Models\Role::class;
    }

    public function getPermissions()
    {
        return Permission::get()->groupBy('group');
    }
    public function createRole(array $data)
    {
        $role = $this->model::create($data);
        if ($data['permissions']) {
            $role->permissions()->attach($data['permissions']);
        }
        return $role;
    }
    public function showRole($id)
    {
        return $this->model->with('permissions')->findOrFail($id);
    }
    public function deleteRole($id)
    {
        $role = $this->model->findOrFail($id);
        $check = $role->users()->count();
        if ($check > 0) {
            return false;
        }
        $role->delete();
        return true;
    }
    public function updateRole(array $data, $id)
    {
        $role = $this->model->findOrFail($id);
        $role->update($data);
        if ($data['permissions']) {
            $role->permissions()->sync($data['permissions']);
        }
        return $role;
    }
}
