<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\User;
use App\Models\Siswa;
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

                if ($role == 'siswa') {
                    $user->siswa()->save(new Siswa([
                        'nis' => $faker->uuid,
                        'name' => $faker->name,
                        'class' => $faker->numberBetween(1, 5),
                        'gender' => $faker->boolean(50) ? 'L' : 'P',
                        'phone' => $faker->phoneNumber,
                        'address' => $faker->address,
                        'status' => 1,
                    ]));
                }
            }
        });
    }
}
