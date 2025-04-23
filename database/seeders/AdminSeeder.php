<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [

            [
                'id'       => 1,
                'name'     => 'Super Admin',
                'avatar'   => 'backend/assets/images/avatar/1.png',
                'email'    => 'superadmin@rishad.com',
                'phone'    => '01920502041',
                'password' => '12345678',
            ],
            [
                'id'       => 2,
                'name'     => 'Demo Admin',
                'avatar'   => 'backend/assets/images/avatar/1.png',
                'email'    => 'superadmin@demo.com',
                'phone'    => '01920502041',
                'password' => '12345678',
            ],

        ];

        foreach ($admins as $admin) {

            DB::table('admins')->insert([
                'id'        => $admin['id'],
                'name'      => $admin['name'],
                'avatar'    => $admin['avatar'],
                'email'     => $admin['email'],
                'phone'     => $admin['phone'],
                'is_active' => 1,
                'password'  => Hash::make($admin['password']),
            ]);
        }
    }
}
