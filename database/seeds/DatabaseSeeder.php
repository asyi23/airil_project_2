<?php

use App\Models\UserType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
        $department = [[
            'deparment_id' => 1,
            'deparment_name' => 'Palleting',
            'department_updated' => now(),
            'department_created' => now(),
        ], [
            'deparment_id' => 2,
            'deparment_name' => '⁠Solvent',
            'department_updated' => now(),
            'department_created' => now(),
        ], [
            'deparment_id' => 3,
            'deparment_name' => '⁠Refinery',
            'department_updated' => now(),
            'department_created' => now(),
        ], [
            'deparment_id' => 4,
            'deparment_name' => '⁠Boiler',
            'department_updated' => now(),
            'department_created' => now(),
        ], [
            'deparment_id' => 5,
            'deparment_name' => '⁠Tank Farm',
            'department_updated' => now(),
            'department_created' => now(),
        ], [
            'deparment_id' => 6,
            'deparment_name' => '⁠ETP',
            'department_updated' => now(),
            'department_created' => now(),
        ]];

        DB::table('tbl_department')->insert($department);

        // $this->call(UsersTableSeeder::class);
        $department = [[
            'username' => 'airil',
            'user_email' => 'airil@gmail.com',
            'password' => Hash::make('Airlil1234#'),
            'user_type_id' => UserType::where('user_type_slug', 'admin')->first()->user_type_id,
            'user_mobile' => '0112312111',
        ]];

        DB::table('tbl_user')->insert($department);
    }
}
