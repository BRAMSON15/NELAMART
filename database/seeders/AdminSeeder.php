<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah admin sudah ada
        $existingAdmin = User::where('role', 'admin')->first();
        
        if ($existingAdmin) {
            $this->command->info('Admin sudah ada: ' . $existingAdmin->email);
            return;
        }

        // Buat admin default
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@nelamart.com',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $this->command->info('✅ Admin berhasil dibuat!');
        $this->command->info('Email: ' . $admin->email);
        $this->command->info('Password: admin123');
        $this->command->warn('⚠️  Jangan lupa ganti password setelah login!');
    }
}
