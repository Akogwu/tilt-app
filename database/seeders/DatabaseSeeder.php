<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //call country and anonymoususer
        $this->call(CountryStateProvinceSeeder::class);
        $this->call(CreateAnonymousUser::class);
        $sql = base_path('database/sql/groups.sql');
        DB::unprepared(file_get_contents($sql));
        $sql = base_path('database/sql/sections.sql');
        DB::unprepared(file_get_contents($sql));
        $sql = base_path('database/sql/questionnaires.sql');
        DB::unprepared(file_get_contents($sql));
        $sql = base_path('database/sql/questionnaire_weight_points.sql');
        DB::unprepared(file_get_contents($sql));

    }
}
