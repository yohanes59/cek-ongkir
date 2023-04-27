<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OngkirController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/list-provinsi', function () {
//     $response = Http::withHeaders([
//         'key' => 'cdabf6cc48974f15008eeff71d97baf8'
//     ])->get('https://api.rajaongkir.com/starter/province');
    
//     $statusCode = $response->json()['rajaongkir']['status']['code'];
//     $provinsi = $response->json()['rajaongkir']['results'];
    
//     // dd($statusCode);
//     dd($provinsi);
// });

// Route::get('/list-city', function () {
//     $response = Http::withHeaders([
//         'key' => 'cdabf6cc48974f15008eeff71d97baf8'
//     ])->get('https://api.rajaongkir.com/starter/city');
    
//     $statusCode = $response->json()['rajaongkir']['status']['code'];
//     $city = $response->json()['rajaongkir']['results'];
    
//     // dd($statusCode);
//     dd($city);
// });

Route::get('/cek-ongkir', [OngkirController::class, 'index']);
Route::post('/cek-ongkir', [OngkirController::class, 'cekOngkir']);

Route::redirect('/', '/cek-ongkir');
