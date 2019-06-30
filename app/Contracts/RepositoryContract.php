<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;


interface RepositoryContract
{
    /**
     * @param Model $model
     * @return mixed
     */
    public function setModel(Model $model);


    /**
     * @return Model $model
     */
    public function getModel();


    /**
     * Get Single Entity By id
     * @param $itemId
     * @return Model
     */
    public function getItemByID($itemId);


    /**
     * Get All Entities at table
     * @return array $items
     */
    public function getAllItems();
}
