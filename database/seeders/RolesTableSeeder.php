<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     * php artisan db:seed --class=RolesTableSeeder
     */
    public function run() {
        $admin = new User();
        $admin->name = 'admin';
        $admin->lastname = 'admin';
        $admin->email = 'admin@gmail.com';
        $admin->password = Hash::make('admin@gmail.com');
        $admin->age = 27;
        $admin->gender = 'male';
        $admin->role = 'admin';
        $admin->active = 1;

        $admin->save();
    }
}
