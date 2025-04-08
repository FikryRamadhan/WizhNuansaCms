<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * @OA\Schema(
     *     schema="Report",
     *     type="object",
     *     @OA\Property(property="id", type="integer", example=1),
     *     @OA\Property(property="title", type="string", example="Monthly Sales Report"),
     *     @OA\Property(property="report", type="string", example="Detailed monthly sales data..."),
     *     @OA\Property(property="source", type="string", example="Finance Department"),
     *     @OA\Property(property="date", type="string", format="date-time", example="2025-04-08T10:00:00Z"),
     *     @OA\Property(property="image", type="string", example="https://example.com/images/report1.jpg"),
     *     @OA\Property(property="created_at", type="string", format="date-time"),
     *     @OA\Property(property="updated_at", type="string", format="date-time")
     * )
     */

    public function index()
    {
        $reports = Report::all();

        if (!$reports) {
            return response()->json([
                'message' => 'Report Is Empty',
            ], 404);
        }

        return response()->json([
            'data' => [
                'reports' => $reports
            ],
            'message' => 'List of reports',
            'code' => 200,
            'status' => 'success'
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/reports/{id}",
     *     tags={"Reports"},
     *     summary="Get a report by ID",
     *     description="Retrieve a single report based on its ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the report",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Report retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="report", ref="#/components/schemas/Report")
     *             ),
     *             @OA\Property(property="message", type="string", example="Get Report Success"),
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="code", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Report Not Found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Report Not Found")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $report = Report::find($id);

        if (!$report) {
            return response()->json([
                'message' => 'Report Not Found'
            ], 404);
        }

        return response()->json([
            'data' => [
                'report' => $report
            ],
            'message' => 'Get Report Success',
            'status' => 'success',
            'code' => 200
        ], 200);
    }
}
