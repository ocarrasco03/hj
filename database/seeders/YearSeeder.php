<?php

namespace Database\Seeders;

use App\Models\Vehicles\Year;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class YearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1940; $i <= date('Y'); $i++) {
            $year = new Year();
            $year->year = $i;
            $year->save();
        }
    }
}
