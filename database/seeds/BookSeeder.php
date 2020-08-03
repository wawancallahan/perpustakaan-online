<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Book;
use App\User;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $user = User::first();

        DB::transaction(function () use ($faker, $user) {
            foreach (range(1, 10) as $range) {
                Book::create([
                    'isbn' => $faker->isbn13,
                    'judul' => $faker->sentence(5),
                    'tahun' => $faker->year($max = 'now'),
                    'pengarang' => $faker->name,
                    'penerbit' => $faker->company,
                    'active' => 1,
                    'created_by' => $user->id
                ]);
            }
        });
    }
}
