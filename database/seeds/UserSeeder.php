<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\User;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = Role::pluck('name');
        $faker = Faker::create('id_ID');

        DB::transaction(function () use ($roles, $faker) {
            foreach ($roles as $role) {
                $user = User::firstOrCreate([
                    'username' => $role
                ], [
                    'name' => $faker->name,
                    'password' => bcrypt('123123'),
                    'is_active' => 1
                ]);
                
                $user->syncRoles([$role]);
            }
        });
    }
}
