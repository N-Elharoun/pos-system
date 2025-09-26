<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use  App\Models\User;
use App\enums\UserStatusEnum;

;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrcreate([
            'username'=>'admin'
        ],
        [
            'username'=>'admin',
            'email'=>'admin@a.com',
            'full_name'=>'pos admin',
            'password'=>bcrypt('11111111'),
            'status'=>UserStatusEnum::Active->value

        ]);
        User::factory(50)->create();
    }
}
