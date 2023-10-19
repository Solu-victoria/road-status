<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ReportResource;

class ReportsController extends Controller
{
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'city' => 'required|string',
            'address' => 'required|string',
            'road_rating' => 'required|string',
            'description' => 'required|string|max:250',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ], [
            'image.max' => 'Image size must not exceed 5 MB',
            'image.mimes' => 'Image formats allowed are jpg,jpeg,png',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        
        $newImageName = time() . '-' . trim($request->image->getClientOriginalName()) . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $newImageName);

        $validatedData = $request->all();
        $validatedData['image'] = env('APP_URL').'/images/'.$newImageName;

        $user = Report::create($validatedData);

        return response()->json([
            'message' => 'You have successfully reported a bad road',
        ], 200);
 
    }

    public function getReports(){
        $Reports = Report::get();
        $ReportsDetails = ReportResource::collection($Reports);
        return $ReportsDetails;
    }
}
