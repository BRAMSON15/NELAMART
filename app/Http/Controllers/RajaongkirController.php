<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RajaongkirController extends Controller
{
    private $baseUrl = 'https://rajaongkir.komerce.id/api/v1';
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = env('RAJAONGKIR_API_KEY', 'y4HWl8ok8b3a2b923f804ae4bfrvOfjT');
    }

    public function getProvinces()
    {
        $response = Http::withoutVerifying()->withHeaders([
            'key' => $this->apiKey
        ])->get($this->baseUrl . '/destination/province');

        $data = $response->json();
        
        // Convert Komerce format to RajaOngkir format for compatibility
        if (isset($data['data'])) {
            return [
                'rajaongkir' => [
                    'results' => array_map(function($item) {
                        return [
                            'province_id' => $item['id'],
                            'province' => $item['name']
                        ];
                    }, $data['data'])
                ]
            ];
        }
        
        return $data;
    }

    public function getCities($provinceId)
    {
        $response = Http::withoutVerifying()->withHeaders([
            'key' => $this->apiKey
        ])->get($this->baseUrl . '/destination/city/' . $provinceId);

        $data = $response->json();
        
        // Convert Komerce format to RajaOngkir format for compatibility
        if (isset($data['data'])) {
            return [
                'rajaongkir' => [
                    'results' => array_map(function($item) {
                        return [
                            'city_id' => $item['id'],
                            'city_name' => $item['name'],
                            'type' => $item['type'] ?? 'Kota'
                        ];
                    }, $data['data'])
                ]
            ];
        }
        
        return $data;
    }

    public function getDistrict($districtId)
    {
        $response = Http::withoutVerifying()->withHeaders([
            'key' => $this->apiKey
        ])->get($this->baseUrl . '/destination/district/' . $districtId);

        return $response->json();
    }

    public function getCost(Request $request)
    {
        $request->validate([
            'origin'      => 'required',
            'destination' => 'required',
            'weight'      => 'required|integer|min:1',
            'courier'     => 'required|string',
        ]);

        // Komerce's domestic cost calculation endpoint
        $response = Http::withoutVerifying()
			->asForm()
			->withHeaders([
            'key' => $this->apiKey
        ])->post($this->baseUrl . '/calculate/domestic-cost', [
            'origin'      => $request->origin,
            'destination' => $request->destination,
            'weight'      => $request->weight,
            'courier'     => $request->courier,
        ]);

        return $response->json();
    }
}