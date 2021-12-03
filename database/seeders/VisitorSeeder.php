<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Visitor;
use Illuminate\Database\Seeder;

class VisitorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::all()->each(function (User $user) {
            $estate = $user->houses->random()->estate;
            $user->visitors()->saveMany(Visitor::factory()->count(rand(1, 5))->make([
                'estate_id' => $estate->id,
            ]));
        });
    }
}
