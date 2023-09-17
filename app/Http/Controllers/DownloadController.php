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
        $table = 'reports_' . Auth::id();
        $reports = $report->write($year, $month, $n_id, $table);
        $years = DB::table($table)->select('year')->distinct()->get();
        $sum['price'] = 0;
        $sum['weight'] = 0;
        foreach ($reports as $item){
            $sum['price'] += $item->price;
            $sum['weight'] += $item->weight;
        }
        $pdf = Pdf::loadView('admin.downloads.report_write', compact('reports', 'sum','years', 'year', 'month', 'n_id', 'table'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('Праводка '. \Illuminate\Support\Facades\Auth::user()->name.'('.$years[0]->year.')'.'.pdf');
    }

    public function calculate(Request $request)
    {
        $report = new Report();

        $dtkt = $request['dtkt'];
        $year = $request['year'];

        $table = 'reports_' . Auth::id();

        $years = DB::table($table)->distinct('year')->pluck('year');
        if ($year == null)
            $year = $years->first();
        $data = $report->calculate($year, $table);

        $table = 'debts_' . Auth::id();
        $debts = DB::table($table)->select('*')->where('year', $year)->get();
        $debt = [];
        foreach ($debts as $item) {
            $debt[$item->dtkt] = $item;
        }

        ksort($data);
        if ($dtkt != null)
            foreach ($data as $key => $value) {
                if (!in_array($key, $dtkt)) {
                    unset($data[$key]);
                    unset($debt[$key]);
                }
            }

        $pdf = Pdf::loadView('admin.downloads.report_calculate', [
            'data' => $data,
            'years' => $years,
            'debt' => $debt,
            'year' => $year,
            'dtkt' => $dtkt,
        ]);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream(Auth::user()->name.$year.'.pdf');
    }
}
