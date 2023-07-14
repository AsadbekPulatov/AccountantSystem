<?php

namespace App\Http\Controllers;

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
        $year = $request['year'];
        $month = $request['month'];
        $n_id = $request['n_id'];
        $table = Auth::user()->table;
        if ($table != null) {
            if ($year != null && $month != null && $n_id != null)
                $reports = DB::table($table)->select('*')->where('year', $year)->where('month', $month)->where('n_id', $n_id)->get();
            else if ($year != null && $month != null)
                $reports = DB::table($table)->select('*')->where('year', $year)->where('month', $month)->get();
            else if ($year != null)
                $reports = DB::table($table)->select('*')->where('year', $year)->get();
            else
                $reports = DB::table($table)->select('*')->get();

            $pdf = Pdf::loadView('admin.downloads.report_write', [
                'reports' => $reports,
                'year' => $year,
                'month' => $month,
                'n_id' => $n_id,
                'table' => $table,
            ]);
            $pdf->setPaper('A4', 'landscape');
            return $pdf->stream('report.pdf');
        }
    }
}
