<?php

namespace Database\Seeders;

use App\Models\House;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserHouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        House::all()->each(function (House $house) {
            $house->users()->save(User::factory()->make(['is_admin' => true]));
            $house->users()->saveMany(User::factory()->count(rand(1, 3))->make());
        });
    }
}
