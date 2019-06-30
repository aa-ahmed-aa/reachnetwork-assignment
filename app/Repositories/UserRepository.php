<?php

namespace App\Repositories;

use App\User;


class UserRepository extends BaseRepository
{
    public function __construct()
    {
        $this->setModel(new User());
    }

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

    public function resetField($user, $field)
    {
        $user->$field = 0;
    }
}
