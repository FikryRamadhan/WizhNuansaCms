<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{
    /**
     * @OA\Info(
     *     version="1.0.0",
     *     title="Tour API Documentation",
     *     description="API documentation for the Tour endpoints",
     *     @OA\Contact(
     *         email="you@example.com"
     *     ),
     *     @OA\License(
     *         name="MIT",
     *         url="https://opensource.org/licenses/MIT"
     *     )
     * )
     */
    /**
     * @OA\Schema(
     *     schema="Tour",
     *     type="object",
     *     title="Tour",
     *     @OA\Property(property="id", type="integer", example=1),
     *     @OA\Property(property="name", type="string", example="Bali Adventure"),
     *     @OA\Property(property="description", type="string", example="An amazing trip to Bali."),
     *     @OA\Property(property="price", type="number", format="float", example=500)
     * )
     */
    /**
     * @OA\Get(
     *     path="/api/tours",
     *     tags={"Tours"},
     *     summary="Get all tours",
     *     @OA\Response(
     *         response=200,
     *         description="List of all tours",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="tours", type="array",
     *                     @OA\Items(ref="#/components/schemas/Tour")
     *                 )
     *             ),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="code", type="integer"),
     *             @OA\Property(property="status", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No tours found"
     *     )
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/tours/{id}",
     *     tags={"Tours"},
     *     summary="Get a specific tour",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Details of a tour",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="tour", ref="#/components/schemas/Tour")
     *             ),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="code", type="integer"),
     *             @OA\Property(property="status", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tour not found"
     *     )
     * )
     */
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
