<?php
namespace App\Managers;

use App\Repositories\UserRepository;

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
     * Get ALl users by page
     * @return array
     */
    public function getAllUsers()
    {
        $users = $this->userRepository->getAllItems();

        return $users;
    }

    /**
     * Get ALl users by page
     * @return array
     */
    public function getAllUsersByPage()
    {
        $users = $this->userRepository->paginateAllItem();

        $response = [];

        foreach($users['data'] as $index => $user)
        {
            $response[] = $this->wrap($user);
        }

        return $response;
    }

    /**
     * Get Single User
     * @param $userId
     * @return mixed
     */
    public function getUserById($userId)
    {
        $user = $this->userRepository->getItemByID($userId);
        return $user;
    }

    /**
     * increment weekly and monthly visits by the user with id $userId
     * @param $userId
     * @return mixed saved user data
     */
    public function incrementUserVisits($userId)
    {

        $user = $this->userRepository->getItemByID($userId);

        $user->weekly_visits_count = (int)$user->weekly_visits_count + 1;
        $user->monthly_visits_count = (int)$user->monthly_visits_count + 1;

        $user = $this->userRepository->saveItem($user);
        return $user;
    }

    /**
     * increment weekly and monthly visits by the user with id $userId
     * @return mixed saved user data
     */
    public function incrementAllUsersViews()
    {

        $users = $this->userRepository->getAllItems(['_id','weekly_views_count','monthly_views_count']);

        $usersAfterIncrement = [];

        foreach($users as $user)
        {
            $user->weekly_views_count = (int)$user->weekly_views_count + 1;
            $user->monthly_views_count = (int)$user->monthly_views_count + 1;
            $usersAfterIncrement[] = $this->userRepository->saveItem($user);
        }

        return $usersAfterIncrement;
    }
}