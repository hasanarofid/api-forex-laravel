<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Ratio;

class HomeController extends Controller
{
    public function index()
    {
        $ratios = Ratio::orderBy('created_at')->get();
        return view('home', compact('ratios'));
    }

    public function fetchAndSaveRatios()
    {
        $response = Http::get('https://c.fxssi.com/api/current-ratios');

        if ($response->successful()) {
            $data = $response->json();
            
            foreach ($data['pairs'] as $pair => $values) {
            foreach($values as $key=>$dt ){
                Ratio::updateOrCreate(
                    ['pair' => $key],
                    ['long' => $dt, 
                     'short' => $dt]
                );

            }
            }

            return response()->json(['message' => 'Ratios fetched and saved successfully']);
        } else {
            return response()->json(['error' => 'Failed to fetch ratios from API'], 500);
        }
    }
}
