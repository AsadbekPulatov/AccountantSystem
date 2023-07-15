<?php

namespace App\Http\Controllers;

use App\Http\Services\Report;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DownloadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user');
    }

    public function write(Request $request)
    {
        $report = new Report();
        $year = $request['year'];
        $month = $request['month'];
        $n_id = $request['n_id'];
        $table = 'reports_'.Auth::id();
        $reports = $report->write($year, $month, $n_id, $table);
        $years = DB::table($table)->select('year')->distinct()->get();
        $pdf = Pdf::loadView('admin.downloads.report_write', compact('reports', 'years', 'year', 'month', 'n_id', 'table'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('report.pdf');
    }
}
