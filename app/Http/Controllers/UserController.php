<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use App\Managers\UserManager;

class UserController extends ApiController
{

    protected $userManager;

    /**
     * UserController constructor injecting the repository instance.
     */
    function __construct()
    {
        $this->userManager = new UserManager();
    }

    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
        $users = $this->userManager->incrementUsersInPage();

        return $this->setStatusCode(200)
            ->respond($users);
    }

    /**
     * Display the specified resource.
     *
     * @param $userId
     * @return mixed
     */
    public function show($userId)
    {
        $user = $this->userManager->getUserById($userId);

        if( ! $user )
        {
            return $this->setStatusCode(404)
                ->respondWithError( "Not Found." );
        }

        $userAfterCountVisit = $this->userManager->incrementUserVisits($user);

        return $this->setStatusCode(200)
            ->respond($userAfterCountVisit);
    }

}
