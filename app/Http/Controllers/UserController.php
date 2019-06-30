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
        $users = $this->userManager->incrementAllUsersViews();

        $users = $this->userManager->getAllUsersByPage();

        return $this->setStatusCode(200)
            ->respond(json_decode($users, true));
    }

    /**
     * Display the specified resource.
     *
     * @param $userId
     * @return mixed
     */
    public function show($userId)
    {
        $userAfterCountVisit = $this->userManager->incrementUserVisits($userId);

        return $this->setStatusCode(200)
            ->respond($userAfterCountVisit);
    }

}
