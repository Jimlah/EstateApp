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
        Estate::factory(10)->create()->each(function ($estate) {
            $estate->managers()->save(Manager::factory()->create());
        });
    }
}
