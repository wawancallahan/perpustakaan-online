<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->datetime('tanggal_pinjam');
            $table->datetime('tanggal_kembali');
            $table->unsignedBigInteger('book_id');
            $table->foreign('book_id')
                    ->references('id')
                    ->on('books');
            $table->unsignedBigInteger('siswa_id');
            $table->foreign('siswa_id')
                    ->references('id')
                    ->on('siswas');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
