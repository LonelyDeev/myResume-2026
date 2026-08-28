<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * اجرای تمام سیدرها
     *
     * دسترسی ادمین پیش‌فرض:
     *   ایمیل: admin@example.com
     *   رمز:   password
     *   ⚠️ بعد از نصب حتماً رمز را تغییر دهید.
     */
    public function run(): void
    {
        // کاربر ادمین (برای ورود به پنل مدیریت)
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'              => 'مدیر سایت',
                'email_verified_at' => now(),
                'password'          => Hash::make('password'),
                'remember_token'    => Str::random(10),
            ]
        );

        // محتوای رزومه
        $this->call(ResumeSeeder::class);
    }
}
