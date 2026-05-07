<?php

// Script untuk membuat user admin
// Jalankan dengan: php create_admin.php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== CREATE ADMIN USER ===\n\n";

// Cek apakah sudah ada admin
$existingAdmin = User::where('role', 'admin')->first();

if ($existingAdmin) {
    echo "Admin sudah ada:\n";
    echo "ID: {$existingAdmin->id}\n";
    echo "Name: {$existingAdmin->name}\n";
    echo "Email: {$existingAdmin->email}\n";
    echo "Role: {$existingAdmin->role}\n\n";
    
    echo "Apakah Anda ingin membuat admin baru? (y/n): ";
    $handle = fopen("php://stdin", "r");
    $line = fgets($handle);
    if (trim($line) != 'y') {
        echo "Dibatalkan.\n";
        exit;
    }
}

// Input data admin
echo "Masukkan data admin baru:\n";

echo "Name: ";
$handle = fopen("php://stdin", "r");
$name = trim(fgets($handle));

echo "Email: ";
$email = trim(fgets($handle));

echo "Username: ";
$username = trim(fgets($handle));

echo "Password: ";
$password = trim(fgets($handle));

// Validasi
if (empty($name) || empty($email) || empty($password)) {
    echo "\nError: Name, email, dan password harus diisi!\n";
    exit;
}

// Cek email sudah ada
if (User::where('email', $email)->exists()) {
    echo "\nError: Email sudah terdaftar!\n";
    exit;
}

// Buat admin
try {
    $admin = User::create([
        'name' => $name,
        'email' => $email,
        'username' => $username ?: null,
        'password' => Hash::make($password),
        'role' => 'admin',
    ]);
    
    echo "\n✅ Admin berhasil dibuat!\n";
    echo "ID: {$admin->id}\n";
    echo "Name: {$admin->name}\n";
    echo "Email: {$admin->email}\n";
    echo "Username: {$admin->username}\n";
    echo "Role: {$admin->role}\n";
    echo "\nSilakan login dengan email: {$admin->email}\n";
    
} catch (\Exception $e) {
    echo "\n❌ Error: " . $e->getMessage() . "\n";
}
