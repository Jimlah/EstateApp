<?php

namespace Database\Seeders;

use App\Models\Estate;
use App\Models\Manager;
use Illuminate\Database\Seeder;

class EstateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Estate::factory(10)->create()->each(function ($estate) {
            $manager = Manager::factory()->create();
            $estate->managers()->attach($manager->id, ['is_admin' =>  false]);
        });
    }
}
