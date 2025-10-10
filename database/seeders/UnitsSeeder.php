<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            ['name' => 'Kilogram','status' => '1'],
            ['name' => 'Liter','status' => '1'],
            ['name' => 'Piece','status' => '1'],
            ['name' => 'Carton','status' => '1'],
        ];
        foreach ($units as $unit) {
            Unit::create($unit);
        }
    }
}
