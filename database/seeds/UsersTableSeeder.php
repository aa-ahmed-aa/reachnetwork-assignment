<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            'weekly_visits_count'  => 1000000,
            'monthly_visits_count' => 1000000,
            'weekly_views_count'   => 1000000,
            'monthly_views_count'  => 1000000,
        ];

        factory(App\User::class, 50000)->create($values);
    }
}
