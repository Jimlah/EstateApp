<?php

namespace Database\Seeders;

use App\Models\Estate;
use App\Models\House;
use Illuminate\Database\Seeder;

class HouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Estate::all()->each(function (Estate $estate) {
            $estate->houses()->saveMany(House::factory(rand(1, 5))->make());
        });
    }
}
