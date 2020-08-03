<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['admin', 'petugas'];

        DB::transaction(function () use ($roles) {
            foreach ($roles as $role) {
                Role::firstOrCreate([
                    'name' => $role
                ]);
            }
        });
    }
}
