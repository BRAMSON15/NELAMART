<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$tokos = DB::table('tokos')->select('id','nama_toko','tipe_pembayaran','nama_ewallet','nomor_ewallet')->get();
foreach ($tokos as $t) {
    echo $t->id . ' | ' . $t->nama_toko . ' | tipe:' . $t->tipe_pembayaran . ' | ewallet:' . $t->nama_ewallet . PHP_EOL;
}
