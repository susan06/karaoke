<?php


namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;


/**
 * Class RepositoryInterface
 *
 * @package Telma\Repositories\Contracts
 *
 */
interface RepositoryInterface
{

    /**
     * Create
     *
     * Creates a new model.
     *
     * @param array $attributes
     *
     * @return Model
     *
     */
    public function create(array $attributes);

    /**
     * First or create.
     *
     * First and returns the first record if
     * exists or creates a new model.
     *
     * @param array $attributes
     *
     * @return mixed
     *
     */
    public function firstOrCreate(array $attributes);

    /**
     * All
     *
     * Gets all models.
     *
     * @param array $attributes
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     *
     */
    public function all(array $attributes = array());

    /**
     * Find.
     *
     * Find a record by it's primary id.
     *
     * @param $id
     *
     * @return mixed
     *
     */
    public function find($id);

    /**
     * Update
     *
     * Update the model find by id with de given data.
     *
     * @param $id
     * @param array $newData
     */
    public function update($id, array $newData);

    /**
     * Where
     *
     * Standard mySql where statement.
     *
     * @param $needle
     * @param $hayStack
     * @param string $option
     *
     * @return mixed
     *
     */
    public function where($needle, $hayStack, $option = '=');

    /**
     * Paginate
     *
     * return the result paginated for the take value and with the attributes.
     *
     * @param int $take
     * @param array $attributes
     *
     * @return mixed
     *
     */
    public function paginate($take = 10, array $attributes = ['*']);

    /**
     * With
     *
     * Return the current model with the relationships given.
     *
     * @param array $relationships
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     *
     */
    public function with(array $relationships);

    /**
     * Active
     *
     * Restoring Soft Deleted Model find by the given id.
     *
     * @param $id
     */
    public function active($id);

    /**
     * Destroy
     *
     * Delete the user find by the given id.
     *
     * @param $id
     */
    public function destroy($id);

}
