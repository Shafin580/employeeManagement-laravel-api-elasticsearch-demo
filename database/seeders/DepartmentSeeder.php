<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = ['Software Development', 'HR', 'Accounts & Finance', 'Marketing', 'Administration'];

        foreach($departments as $department){
            DB::table('departments')->insert([
                'name' => $department,
            ]);
        }
    }
}
