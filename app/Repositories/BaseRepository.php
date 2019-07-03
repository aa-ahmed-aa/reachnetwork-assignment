<?php

namespace App\Repositories;

use App\Contracts\RepositoryContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;


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
     * @param $itemID
     * @return Model
     */
    public function getItemByID($itemID)
    {
        return $this->model->where( '_id', '=', $itemID )->get()->first();
    }


    /**
     * @param array $fields
     * @return array
     */
    public function getAllItems( $fields = array() )
    {
        return $this->model->all($fields);
    }

}
