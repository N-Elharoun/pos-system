<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Safe;
use App\Enums\SafeStatusEnum;
use App\Enums\SafeTypeEnum;

class SafesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $safes = [
            'Cash',
            'Instapay ',
            'VodaCash ',
        ];
        foreach ($safes as $safe) {
            Safe::updateOrCreate([
            'name' => $safe,
            ], [
                'name' => $safe,
                'balance' => 0,
                'status' => SafeStatusEnum::Active,
                'description' => null,
                'type' => $safe == 'Cash' ? SafeTypeEnum::Cash : SafeTypeEnum::Online,
            ]);
        }
    }
}
