<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clients')->insert([
            [
                'identification' => '0956897412001',
                'name' => 'Pueba 1',
                'status' => 'A',
            ],
            [
                'identification' => '0956897412002',
                'name' => 'Pueba 2',
                'status' => 'A',
            ]
        ]);
    }
}
