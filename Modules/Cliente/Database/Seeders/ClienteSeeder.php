<?php

namespace Modules\Cliente\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Cliente\Models\Cliente;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cliente::factory()->count(5)->create();
    }
}
