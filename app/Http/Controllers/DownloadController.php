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

        if ($dtkt != null)
            foreach ($data as $key => $value) {
                if (!in_array($key, $dtkt)) {
                    unset($data[$key]);
                    unset($debt[$key]);
                }
            }

        foreach ($debt as $key => $item){
            if (!isset($data[$key])){
                $data[$key] = [
                    'data' => [],
                    'dt_weight' => 0,
                    'kt_weight' => 0,
                    'dt_price' => 0,
                    'kt_price' => 0,
                ];
            }
        }
        ksort($data);
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

    public function debt(Request $request){
        $debt = new Report();
        $year = $request['year'];
        $dtkt = $request['dtkt'];
        $table = 'debts_'.Auth::id();
        $debts = $debt->debt($year, $dtkt, $table);
        $years = DB::table($table)->select('year')->distinct('year')->pluck('year');
        $sum['dt_price'] = 0;
        $sum['kt_price'] = 0;
        foreach ($debts as $debt){
            $sum['dt_price']+=$debt->dt_price;
            $sum['kt_price']+=$debt->kt_price;
        }
        $pdf = Pdf::loadView('admin.downloads.report_debts', [
            'debts' => $debts,
            'year' => $year,
            'sum' => $sum,
        ]);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream(Auth::user()->name.$year.'.pdf');
    }
}
