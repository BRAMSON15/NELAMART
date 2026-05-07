<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "=== ADMIN USERS ===\n\n";

$admins = User::where('role', 'admin')->get(['id', 'name', 'email', 'username']);

if ($admins->isEmpty()) {
    echo "❌ Tidak ada admin di database!\n";
    echo "\nJalankan: php artisan db:seed --class=AdminSeeder\n";
} else {
    echo "✅ Ditemukan " . $admins->count() . " admin:\n\n";
    foreach ($admins as $admin) {
        echo "ID: {$admin->id}\n";
        echo "Name: {$admin->name}\n";
        echo "Email: {$admin->email}\n";
        echo "Username: " . ($admin->username ?? 'null') . "\n";
        echo "---\n";
    }
    
    echo "\n📝 Gunakan kredensial di atas untuk login di /admin/login\n";
}
