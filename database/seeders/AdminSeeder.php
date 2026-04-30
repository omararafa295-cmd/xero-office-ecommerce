<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@xero.com'], // لو الإيميل ده موجود هيحدثه، لو مش موجود هيكريته
            [
                'name' => 'المدير العام',
                'password' => Hash::make('password123'), // الباسورد
                'is_admin' => true, // إعطاء صلاحية الإدارة
            ]
        );
    }
}