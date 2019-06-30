<?php

namespace App\Repositories;

use App\Contracts\RepositoryContract;
use Illuminate\Database\Eloquent\Model;


abstract class BaseRepository implements RepositoryContract
{
    protected $model;


    /**
     * Get Class Model
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }


    /**
     * @param Model $model
     * @return RepositoryContract $this
     */
    public function setModel(Model $model)
    {
        $this->model = $model;
        return $this;
    }


    /**
     * Get Single Entity By id
     * @param $itemId
     * @return Model
     */
    public function getItemByID($userId)
    {
        return $this->model->where( '_id', '=', $userId )->get()->first();
    }


    /**
     * Get All Entities at table
     * @return array $items
     */
    public function getAllItems()
    {
        return $this->model->all();
    }

    /**
     * save Increment weekly and monthly visits
     * @param $user
     * @return mixed
     */
    public function saveUser($user)
    {
        $user->save();
        return $user;
    }

    /**
     * @return array $items
     */
    public function paginateAllItem()
    {
        $usersPage = $this->model->paginate(15);
        return $json  = json_encode($usersPage);;
    }
}
