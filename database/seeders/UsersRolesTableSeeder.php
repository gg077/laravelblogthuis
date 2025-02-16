<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $roles = Role::all();
        //dynamisch toekennen van x aantal rollen aan iedere users
        User::all()->each(function($user) use ($roles){
            $roleCount = rand(1, $roles->count());
            $selectedRoles = $roles->random($roleCount)->pluck('id')->toArray();
            //wegschrijven naar tussentabel
            $user->roles()->attach($selectedRoles);
        });
    }
}
