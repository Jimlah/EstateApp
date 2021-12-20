<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Manager;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('passport:install');
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
            'is_admin' => true,
        ]);

        Admin::find(2)->update([
            'email' => 'admin@admin.com',
            'password' => 'password',
            'is_admin' => false,
        ]);


        Manager::first()->update([
            'email' => 'superadmin@manager.com',
            'password' => 'password',
            'is_admin' => true,
        ]);

        Manager::find(2)->update([
            'email' => 'admin@manager.com',
            'password' => 'password',
            'is_admin' => false,
        ]);

        User::first()->update([
            'email' => 'admin@house.com',
            'password' => 'password',
            'is_admin' => true,
        ]);

        User::find(2)->update([
            'email' => 'user@house.com',
            'password' => 'password',
            'is_admin' => false,
        ]);
    }
}
