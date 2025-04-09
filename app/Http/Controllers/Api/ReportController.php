<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
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
