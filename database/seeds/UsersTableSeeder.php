<?php

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
            'total_views'  => 1000000,
            'total_visits' => 1000000,
        ];

        factory(App\User::class, 50000)->create($values);
    }
}
