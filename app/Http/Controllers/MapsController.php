<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MapsController extends Controller
{
    public function trafficInfo(Request $request)
    { 
        $apiKey = env('GOOGLE_MAPS_API_KEY');
        $latitude = 6.366073;
        $longitude = 7.519917;
        $response = Http::get('https://maps.googleapis.com/maps/api/traffic/json?location='.$latitude.','.$longitude.'&zoom=13&bbox=6.285373,7.448219,6.468089,7.588056&maxResults=10&format=json&key='.$apiKey);
        // https://maps.googleapis.com/maps/api/traffic/json?location=6.366073,7.519917&zoom=13&bbox=6.285373,7.448219,6.468089,7.588056&maxResults=10&format=json&key=AlzaSvCIkHOEHskH56Pt4ts-JLHYSPEr27x4xPA
        dd($response);
        // $trafficData = $response->json();
        // return response()->json($trafficData);
    }
}
