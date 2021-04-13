<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class CountryStateProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $country = base_path('database/sql/country.sql');
        \Illuminate\Support\Facades\DB::unprepared(file_get_contents($country));

        $state = base_path('database/sql/states.sql');
        \Illuminate\Support\Facades\DB::unprepared(file_get_contents($state));

    }
}
