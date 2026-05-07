<?php
$apiKey = 'y4HWl8ok8b3a2b923f804ae4bfrvOfjT';

// Check city
$ch = curl_init('https://rajaongkir.komerce.id/api/v1/destination/city?province=5');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('key: ' . $apiKey));
echo "CITY\n";
echo curl_exec($ch) . "\n\n";

// Check cost
$ch2 = curl_init('https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost');
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch2, CURLOPT_POST, 1);
curl_setopt($ch2, CURLOPT_POSTFIELDS, "origin=114&destination=115&weight=1000&courier=jne");
curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch2, CURLOPT_HTTPHEADER, array('key: ' . $apiKey, 'Content-Type: application/x-www-form-urlencoded'));
echo "COST\n";
echo curl_exec($ch2) . "\n\n";
