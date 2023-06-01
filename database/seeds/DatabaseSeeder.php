<?php

use Illuminate\Database\Seeder;
use App\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'role' => 'User',
            ],
            [
                'role' => 'Admin',
            ],
        ];

        foreach ($roles as $roleData) {
            Role::create($roleData);
        };
    }
}
