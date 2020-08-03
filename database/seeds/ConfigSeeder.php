<?php

use Illuminate\Database\Seeder;
use App\Models\Config;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $configs = [
            'denda' => 500
        ];

        DB::transaction(function () use ($configs) {
            foreach ($configs as $name => $value) {
                Config::firstOrCreate([
                    'name' => $name
                ], [
                    'value' => $value
                ]);
            }
        });
    }
}
