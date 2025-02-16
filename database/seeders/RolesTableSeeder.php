<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'name' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'author',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'subscriber',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
