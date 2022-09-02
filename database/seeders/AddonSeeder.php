<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('addons')->insert([
            'name' => 'Bacon',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('addons')->insert([
            'name' => 'Extra Cheese',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('addons')->insert([
            'name' => 'Onion',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('addons')->insert([
            'name' => 'Mushroom',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
