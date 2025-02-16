<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('users')->insert([
            'name'=>'Artur',
            'is_active'=>1,
            'email'=>'team@gmail.com',
            'email_verified_at'=>now(),
            'photo_id'=>1,
            'password'=>Hash::make('12345678'),
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);

        User::factory()->count(50)->create();
    }
}
