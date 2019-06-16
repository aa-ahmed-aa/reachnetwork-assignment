<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function getUserById()
    {
        $user = factory(User::class)->create();

        $this->get('/api/v1/users/'.$user->id)
            ->assertStatus(200);
    }

    /** @test */
    public function gettingSingleUserShouldRecordNewVisit()
    {
        $user = factory(User::class)->create();

        $this->get('/api/v1/users/'.$user->id)
            ->assertJsonFragment(['weekly_visits_count' => 1])
            ->assertJsonFragment(['monthly_visits_count' => 1]);

        $this->get('/api/v1/users/'.$user->id)
            ->assertJsonFragment(['weekly_visits_count' => 2])
            ->assertJsonFragment(['monthly_visits_count' => 2]);
    }

    /** @test */
    public function gettingAllUsersShouldRecordNewViewForEachUser()
    {
        $user = factory(User::class)->create();

        $this->get('/api/v1/users')
            ->assertStatus(200);

        $this->get('/api/v1/users/'.$user->id)
            ->assertJsonFragment(['weekly_views_count' => 1])
            ->assertJsonFragment(['monthly_views_count' => 1]);
    }


    /** @test */
    public function getPopularUsersOrderedByWeeklyVisits()
    {
        $poorGuy = factory(User::class)->create();
        $popularGuy = factory(User::class)->create();
        $normalGuy = factory(User::class)->create();

        for ($i = 0; $i <= 10; $i++){
            $this->get('/api/v1/users/'.$popularGuy->id);
        }

        for ($i = 0; $i <= 5; $i++){
            $this->get('/api/v1/users/'.$normalGuy->id);
        }


        $this->get('/api/v1/users')
            ->assertStatus(200)
            ->assertJson([
                ['id' => $popularGuy->id],
                ['id' => $normalGuy->id],
                ['id' => $poorGuy->id]
            ]);
    }
}
