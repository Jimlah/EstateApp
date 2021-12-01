<?php

namespace Database\Seeders;

use App\Models\Estate;
use App\Models\Manager;
use Illuminate\Database\Seeder;

class EstateManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Estate::all()->each(function (Estate $estate) {
            $estate->managers()->save(Manager::factory()->make(['is_admin' => true]));
        });
    }
}
