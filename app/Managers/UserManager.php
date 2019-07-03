<?php
namespace App\Managers;

use App\Jobs\IncrementUsersViews;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Cache;

class UserManager extends BaseManager
{
    protected $userRepository;

    /**
     * PostManager constructor.
     */
    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    /**
     * Get Single User
     * @param $userId
     * @return mixed
     */
    public function getUserById($userId)
    {
        return Cache::remember( 'user_'. $userId, 999999, function () use ($userId) {
            return $this->userRepository->getItemByID($userId);
        });
    }

    /**
     * increment weekly and monthly visits by the user with id $userId
     * @param $user
     * @return mixed saved user data
     */
    public function incrementUserVisits($user)
    {
        $user->weekly_visits_count = (int)$user->weekly_visits_count + 1;
        $user->monthly_visits_count = (int)$user->monthly_visits_count + 1;
        $user->total_visits = (int)$user->total_visits + 1;

        $user = $this->userRepository->saveUser($user);
        return $user;
    }

    /**
     * increment Users in page
     */
    public function incrementUsersInPage()
    {
        $users = $this->userRepository->paginateUsers();

        //get single items from the cache not the total page
        $upToDateUsers = [];
        foreach ($users['data'] as $user)
        {
            $upToDateUsers[] = Cache::get('user_'.$user['_id']);
        }

        $usersAfterIncrement = [];

        foreach($upToDateUsers as $user)
        {

            $user['weekly_views_count'] = (int)$user['weekly_views_count'] + 1;
            $user['monthly_views_count'] = (int)$user['monthly_views_count'] + 1;
            $user['total_views'] = (int)$user['total_views'] + 1;

            $newUser = $this->userRepository->saveUserFromArray($user);

            $usersAfterIncrement[] = $this->wrap($newUser);
        }

        return $usersAfterIncrement;
    }
}