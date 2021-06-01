<?php


namespace App\Repository;


use App\Models\School;

class SchoolRepository
{

    public static function countSchool()
    {
        return School::count();
    }

}
