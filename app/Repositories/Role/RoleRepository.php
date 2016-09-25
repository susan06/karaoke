<?php

namespace App\Repositories\Role;

use App\Repositories\RepositoryInterface;
use App\Role;

interface RoleRepository extends RepositoryInterface
{
    /**
     * Lists all system roles into $key => $column value pairs.
     *
     * @param string $column
     * @param string $key
     * @return mixed
     */
    public function lists($column = 'name', $key = 'id');

    /**
     * Get all system roles with number of users for each role.
     *
     * @return mixed
     */
    public function getAllWithUsersCount();

    /**
     * Find role by name:
     *
     * @param $name
     * @return mixed
     */
    public function findByName($name);

    /**
     * Create new system role.
     *
     * @param array $data
     * @return Role
     */
    public function create(array $data);

    /**
     * Update specified role.
     *
     * @param $id Role Id
     * @param array $data
     * @return Role
     */
    public function update($id, array $data);

    /**
     * Remove role from repository.
     *
     * @param $id Role Id
     * @return bool
     */
    public function delete($id);

}