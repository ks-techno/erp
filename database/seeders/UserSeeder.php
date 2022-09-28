<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['name'=>'admin','email'=>'admin@gmail.com']
        ];
        foreach($users as $user){
            if(!User::where('email',$user['email'])->exists()){
                User::create([
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'password' => Hash::make('123456'),
                    'user_status' => 1,
                ]);
            }
        }
    }
}
