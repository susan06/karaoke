<?php

namespace App\Repositories\Role;

use App\Events\Role\Created;
use App\Events\Role\Deleted;
use App\Events\Role\Updated;
use App\Role;
use App\Support\Authorization\CacheFlusherTrait;
use DB;
use App\Repositories\Repository;

class EloquentRole extends Repository implements RoleRepository
{
    use CacheFlusherTrait;

    /**
     * EloquentRole constructor.
     *
     * @param Role $role
     *
     */
    public function __construct(Role $role)
    {
        parent::__construct($role);
    }

    /**
     * {@inheritdoc}
     */
    public function lists($column = 'name', $key = 'id')
    {
        return Role::lists($column, $key);
    }

    /**
     * {@inheritdoc}
     */
    public function getAllWithUsersCount()
    {
        $prefix = DB::getTablePrefix();

        return Role::leftJoin('role_user', 'roles.id', '=', 'role_user.role_id')
            ->select('roles.*', DB::raw("count({$prefix}role_user.user_id) as users_count"))
            ->groupBy('roles.id')
            ->get();
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        $role = Role::create($data);

        event(new Created($role));

        return $role;
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        $role = $this->find($id);

        $role->update($data);

        event(new Updated($role));

        return $role;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $role = $this->find($id);

        event(new Deleted($role));

        return $role->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function updatePermissions($roleId, array $permissions)
    {
        $role = $this->find($roleId);

        $role->perms()->sync($permissions);

        $this->flushRolePermissionsCache($role);
    }

    /**
     * {@inheritdoc}
     */
    public function findByName($name)
    {
        return Role::where('name', $name)->first();
    }
}