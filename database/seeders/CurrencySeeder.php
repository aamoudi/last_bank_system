<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('currencies')->count() > 0) {
            return;
        }

        DB::table('currencies')->insert([
            ['name' =>'US Dollar - USD' , 'active' => '1'],
            ['name' =>'Saudi Riyal - SAR' , 'active' => '1'],
            ['name' =>'New Israeli Sheqel - ILS' , 'active' => '1'],
            ['name' =>'Jordanian Dinar - JOD' , 'active' => '1'],
        ]);
    }
}
