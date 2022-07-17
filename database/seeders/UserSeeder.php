<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = ["admin", "employee"];
        $email = ["admin@gmail.com", "employee@gmail.com"];
        $password = ["password01", "password02"];
        $roleId = [1, 2];

        for($i = 0; $i < 2; $i++){

            DB::table('users')->insert([
                'name' => $name[$i],
                'email' => $email[$i],
                'password' => Hash::make($password[$i]),
                'role_id' => $roleId[$i],
            ]);
        }
    }
}
