<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'name' => 'Shukant Mukherjee',
            'username' => 'diuadmin',
            'email' => 'admin@diutransport.com',
            'mobile' => '01824713030',
            'password' => '$2y$10$V8HnsCylKImmbNZ5/LqxQ.GDme0JQRKk9/QIU27ucg7JrkqEFVCda', //123456
            'usertype' => 'Admin',
            'profile_photo' => 'sukanto.jpg',
            'registered_by' => 'System Administrator',
        ]);
    }
}
