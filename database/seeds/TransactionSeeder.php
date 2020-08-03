<?php

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\Siswa;
use Carbon\Carbon;
use Faker\Factory as Faker;
use App\Models\Book;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $siswas = Siswa::pluck('id');
        $books = Book::pluck('id');

        DB::transaction(function () use ($faker, $siswas, $books) {
            foreach ($siswas as $siswa_id) {
                Transaction::create([
                    'tanggal_pinjam' => Carbon::now(),
                    'tanggal_kembali' => Carbon::now()->addDays(5),
                    'book_id' => $books->random(),
                    'siswa_id' => $siswa_id
                ]);
            }
        });
    }
}
