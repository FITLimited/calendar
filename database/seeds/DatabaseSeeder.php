<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->delete();
        DB::table('user_roles')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->call(UserRolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
