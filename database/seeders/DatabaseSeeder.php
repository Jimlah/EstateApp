<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Admin::factory(5)->create();

        $this->call([
            EstateSeeder::class,
            EstateManagerSeeder::class,
            HouseSeeder::class,
            UserHouseSeeder::class,
            VehicleSeeder::class
        ]);

        Admin::first()->update([
            'email' => 'superadmin@admin.com',
            'password' => 'password',
        ]);
    }
}
