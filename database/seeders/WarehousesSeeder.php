<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Enums\WarehouseStatusEnum;
use App\Models\Warehouse;

class WarehousesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $warehouses = [
            [
                'name' => 'Main Warehouse',
                'description' => 'The primary warehouse for all products.',
                'status' => WarehouseStatusEnum::Active->value,
            ],
            [
                'name' => 'Secondary Warehouse',
                'description' => 'Backup storage for overflow inventory.',
                'status' => WarehouseStatusEnum::Active->value    ,
            ],
            [
                'name' => 'Old Warehouse',
                'description' => 'Warehouse for discontinued products.',
                'status' => WarehouseStatusEnum::Active->value ,
            ],
        ];
        foreach ($warehouses as $warehouse) {
            Warehouse::create($warehouse);
        }
    }
}
