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
    public function getItemByID($itemID)
    {
        return $this->model->where( '_id', '=', $itemID )->get()->first();
    }


    /**
     * @param null $fields
     * @return array
     */
    public function getAllItems( $fields = null )
    {
        return $this->model->all($fields);
    }

    /**
     * save Increment weekly and monthly visits
     * @param $item
     * @return mixed
     */
    public function saveItem($item)
    {
        $item->save();
        return $item;
    }

    /**
     * @return array $items
     */
    public function paginateAllItem()
    {
        $itemsPage = $this->model->orderBy('weekly_visits_count', 'desc')->paginate(15);
        $users = json_encode($itemsPage);
        return json_decode($users, true);
    }
}
