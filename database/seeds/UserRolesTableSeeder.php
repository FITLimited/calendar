<?php

use Illuminate\Database\Seeder;

use App\Models\UserRole;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->insert([
            'id'    => 1,
            'role'  => UserRole::ADMIN
        ]);

        DB::table('user_roles')->insert([
            'id'    => 2,
            'role'  => UserRole::USER
        ]);
    }
}
