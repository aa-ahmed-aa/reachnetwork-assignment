<?php

namespace App\Repositories;

use App\User;
use Illuminate\Support\Facades\Cache;


class UserRepository extends BaseRepository
{
    public function __construct()
    {
        $this->setModel(new User());
    }

    /**
     * Called by the cron job to reset the counter every week
     */
    public static function resetWeekly()
    {
        $users = User::all();

        foreach($users as $user)
        {
            $user->weekly_visits_count = 0;
            $user->weekly_views_count = 0;
            $user->save();
        }
    }

    /**
     * Called by the cron job to reset the counter every month
     */
    public static function resetMonthly()
    {
        $users = User::all();

        foreach($users as $user)
        {
            $user->monthly_visits_count = 0;
            $user->monthly_views_count = 0;
            $user->save();
        }
    }

    /**
     * Reset specific field number to 0
     * @param $user
     * @param $field
     */
    public function resetField($user, $field)
    {
        $user->$field = 0;
    }

    /**
     * save Increment weekly and monthly visits
     * @param $item
     * @return mixed
     */
    public function saveUser($user)
    {
        //save item in the database
        $user->save();

        //save item in the cache
        Cache::put('user_'. $user->_id, $user);

        return $user;
    }

    public function getUserById($userID)
    {
        return $this->getItemByID($userID);
    }

    /**
     * Save the user data from an array
     * @param $user
     * @return mixed
     */
    public function saveUserFromArray($user)
    {
        //update the user in database
        $oldUser = Cache::remember('user_'. $user['_id'], 999999, function () use ($user) {
            return $this->getUserById($user['_id']);
        });
        $oldUser->weekly_views_count = $user['weekly_views_count'];
        $oldUser->monthly_views_count = $user['monthly_views_count'];
        $oldUser->total_views = $user['total_views'];

        $oldUser->save();

        //update the user in cache
        Cache::put('user_'. $oldUser->_id, $oldUser, 999999);

        return $oldUser;
    }

    /**
     * @return array $items
     */
    public function paginateUsers()
    {
        $users = $this->model->orderBy('weekly_visits_count', 'desc')->paginate(15);

        foreach($users as $index => $user)
        {
            Cache::remember('user_'. $user->_id , 999999, function () use ($user) { return $user; });
        }

        $usersObject = json_encode($users);
        return json_decode($usersObject, true);
    }
}
