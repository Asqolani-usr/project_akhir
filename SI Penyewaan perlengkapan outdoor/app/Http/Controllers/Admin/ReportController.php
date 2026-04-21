<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReportService;

class ReportController extends Controller
{
    public function index(ReportService $reportService)
    {
        $reports = $reportService->generate();
        return view('admin.reports', compact('reports'));
    }
}
