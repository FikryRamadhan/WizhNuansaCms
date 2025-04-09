<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{


    public function index()
    {
        $tours = Tour::all();
        if ($tours->isEmpty()) {
            return response()->json([
                'message' => 'No tours found'
            ], 404);
        }
        return response()->json([
            'data' => [
                'tours' => $tours
            ],
            'message' => 'List of all tours',
            'code' => 200,
            'status' => 'success'
        ])->setStatusCode(200, 'OK');
    }


    public function show($id)
    {
        $tour = Tour::find($id);
        if (!$tour) {
            return response()->json([
                'message' => 'Tour not found'
            ], 404);
        }
        return response()->json([
            'data' => [
                'tour' => $tour
            ],
            'message' => 'Details of tour with Name: ' . $tour->name,
            'code' => 200,
            'status' => 'success'
        ])->setStatusCode(200, 'OK');
    }
}
