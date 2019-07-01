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
        $_GET['page'] = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        $itemsPage = $this->model->orderBy('weekly_visits_count', 'desc')->paginate(15);

        $cachedItems = [];
        foreach($itemsPage as $index => $item)
        {
            $cachedItems[] = Cache::remember('item_'. $item->_id .'_page_'.$_GET['page'], 999999, function () use ($item) {
                return $item;
            });
        }

        $items = json_encode($cachedItems);
        return json_decode($items, true);
    }
}
