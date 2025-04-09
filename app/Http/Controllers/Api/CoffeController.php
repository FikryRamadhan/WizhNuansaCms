<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coffe;
use Illuminate\Http\Request;

class CoffeController extends Controller
{
    public function index(){
        $coffes = Coffe::all();
        if ($coffes->isEmpty()) {
            return response()->json([
                'message' => 'No coffe found'
            ], 404);
        }
        return response()->json([
            'data' => [
                'coffes' => $coffes
            ],
            'message' => 'List of all coffes',
            'code' => 200,
            'status' => 'success'
        ])->setStatusCode(200, 'OK');
    }
}
