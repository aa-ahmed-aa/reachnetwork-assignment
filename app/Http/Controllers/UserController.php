<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\User;


class UserController extends ApiController
{

    protected $userRepository;

    /**
     * UserController constructor injecting the repository instance.
     * @param $userRepository
     */
    function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->userRepository->paginateAllItem();
        return json_decode($users, true);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return json_decode($user);
    }

}
