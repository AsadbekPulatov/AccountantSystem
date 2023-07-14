<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function calculate(Request $request)
    {
        $dtkt = $request['dtkt'];
        $table = 'reports_'.Auth::id();
        $year = $request['year'];
        $years = DB::table($table)->select('year')->distinct()->get();
        if ($year == null)
            $year = $years[0]->year;
        $reports = DB::table($table)->select('*')->where('year', $year)->get();
        $data = [];
        foreach($reports as $report){
            $data[$report->dt]['data'] = [];
            $data[$report->dt]['dt_weight'] = 0;
            $data[$report->kt]['dt_weight'] = 0;
            $data[$report->dt]['kt_weight'] = 0;
            $data[$report->kt]['kt_weight'] = 0;
            $data[$report->dt]['dt_price'] = 0;
            $data[$report->kt]['dt_price'] = 0;
            $data[$report->dt]['kt_price'] = 0;
            $data[$report->kt]['kt_price'] = 0;
        }
        foreach($reports as $report){
            $data[$report->dt]['data'][] = $report;
            $data[$report->kt]['data'][] = $report;
            $data[$report->dt]['dt_weight'] += $report->weight;
            $data[$report->kt]['kt_weight'] += $report->weight;
            $data[$report->dt]['dt_price'] += $report->price;
            $data[$report->kt]['kt_price'] += $report->price;
        }
        ksort($data);
        if ($dtkt != null)
        foreach ($data as $key => $value){
            if (!in_array($key, $dtkt))
                unset($data[$key]);
        }
        return view('admin.reports.calculate', [
            'data' => $data,
            'years' => $years,
        ]);
    }

    public function index(Request $request)
    {
        $year = $request['year'];
        $month = $request['month'];
        $n_id = $request['n_id'];
        $table = 'reports_'.Auth::id();
        if ($table != null) {
            if ($year != null && $month != null && $n_id != null)
                $reports = DB::table($table)->select('*')->where('year', $year)->where('month', $month)->where('n_id', $n_id)->get();
            else if ($year != null && $month != null)
                $reports = DB::table($table)->select('*')->where('year', $year)->where('month', $month)->get();
            else if ($year != null)
                $reports = DB::table($table)->select('*')->where('year', $year)->get();
            else
                $reports = DB::table($table)->select('*')->get();
            $years = DB::table($table)->select('year')->distinct()->get();
            return view('admin.reports.index', [
                'reports' => $reports,
                'years' => $years,
                'year' => $year,
                'month' => $month,
                'n_id' => $n_id,
                'table' => $table,
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.reports.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [];
        for ($i = 0; $i < count($request['title']); $i++) {
            $request['price'] = str_replace(',','.', $request['price']);
            $data[] = [
                'n_id' => $request['n_id'],
                'year' => $request['year'],
                'month' => $request['month'],
                'title' => $request['title'][$i],
                'weight' => $request['weight'][$i],
                'dt' => $request['dt'][$i],
                'kt' => $request['kt'][$i],
                'price' => $request['price'][$i],
            ];
        }
        $table = 'reports_'.Auth::id();
        DB::table($table)->insert($data);
        return redirect()->route('reports.index')->with('success', 'Report created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $table = 'reports_'.Auth::id();
        $report = DB::table($table)->find($id);
        return view('admin.reports.edit', compact('report'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $table = 'reports_'.Auth::id();
        DB::table($table)->where('id', $id)->update([
            'n_id' => $request['n_id'],
            'year' => $request['year'],
            'month' => $request['month'],
            'title' => $request['title'],
            'weight' => $request['weight'],
            'dt' => $request['dt'],
            'kt' => $request['kt'],
            'price' => $request['price'],
        ]);
        return redirect()->route('reports.index')->with('success', 'Report updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $table = 'reports_'.Auth::id();
        DB::table($table)->where('id', $id)->delete();
        return redirect()->route('reports.index')->with('success', 'Report deleted successfully');
    }
}
