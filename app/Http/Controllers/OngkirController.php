<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OngkirController extends Controller
{
    public function index()
    {
        $responseProvince = Http::withHeaders([
            'key' => config('rajaongkir.key')
        ])->get(config('rajaongkir.province_url'));

        $responseCity = Http::withHeaders([
            'key' => config('rajaongkir.key')
        ])->get(config('rajaongkir.city_url'));

        $provinces = $responseProvince['rajaongkir']['results'];
        $cities = $responseCity['rajaongkir']['results'];

        return view('cek-ongkir', [
            'provinces' => $provinces,
            'cities' => $cities,
            'ongkir' => ''
        ]);
    }

    public function cekOngkir(Request $request)
    {
        $responseProvince = Http::withHeaders([
            'key' => config('rajaongkir.key')
        ])->get(config('rajaongkir.province_url'));

        $response = Http::withHeaders([
            'key' => config('rajaongkir.key')
        ])->get(config('rajaongkir.city_url'));

        $responseCost = Http::withHeaders([
            'key' => config('rajaongkir.key')
        ])->post(config('rajaongkir.cost_url'), [
            'origin' => $request->origin,
            'destination' => $request->destination,
            'weight' => $request->weight,
            'courier' => $request->courier,
        ]);

        $provinces = $responseProvince['rajaongkir']['results'];
        $cities = $response['rajaongkir']['results'];
        $ongkir = $responseCost['rajaongkir'];
        return view('cek-ongkir', [
            'provinces' => $provinces,
            'cities' => $cities, 
            'ongkir' => $ongkir
        ]);
    }
}
