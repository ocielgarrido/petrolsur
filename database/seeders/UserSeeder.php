<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       User::create([
            'name'=> 'Ociel Garrido',
            'email'=> 'ocielgarrido@gmail.com',
            'password'=>bcrypt('Tute1535')
       ])->asignRole('Admin');
    }
}
