<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('test')->insert([
            'FIO' => 'Рома',
            'Year' => '18',
            'Rost' => '78.5',
            'Ves' => '65' ]);
    }
}
