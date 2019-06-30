<?php
namespace App\Managers;


abstract class BaseManager
{
    public function wrap($user)
    {
        return [
            'id' => $user['_id']
        ];
    }
}
