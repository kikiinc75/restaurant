<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('users')->insert([
            'name' => 'iqbal',
            'email' => 'wahyuiqbal91@gmail.com',
            'password' => bcrypt('password'),
            'level' => 'kasir',
        ], [
            'name' => 'kasir',
            'email' => 'kasir@gmail.com',
            'password' => bcrypt('password'),
            'level' => 'kasir',
        ], [
            'name' => 'pelayan',
            'email' => 'pelayan@gmail.com',
            'password' => bcrypt('password'),
            'level' => 'pelayan',
        ]);
    }
}
