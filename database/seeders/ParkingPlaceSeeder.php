<?php

namespace Database\Seeders;

use App\Models\ParkingPlace;
use Illuminate\Database\Seeder;

class ParkingPlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++)
        {
            ParkingPlace::create([
                'number' => $i,
                'price' => $i * rand(1,10)
            ]);
        }
    }
}
