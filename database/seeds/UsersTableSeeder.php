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
        DB::table('users')->delete();
        foreach (range(1,35) as $index)
        {
            factory(App\User::class)->create(['id'=>$index]);
        }
    }
}
