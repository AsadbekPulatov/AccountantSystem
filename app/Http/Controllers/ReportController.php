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
        $year = $request['year'];

        $table = 'debts_'.Auth::id();
        $years = DB::table($table)->distinct('year')->pluck('year');
        if ($year == null)
            $year = $years->first();
        $debts = DB::table($table)->select('*')->where('year', $year)->get();
        $debt = [];
        foreach ($debts as $item){
            $debt[$item->dtkt] = $item;
        }

        $table = 'reports_'.Auth::id();
        $years = DB::table($table)->distinct('year')->pluck('year');
        if ($year == null)
            $year = $years->first();
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
            if (!in_array($key, $dtkt)){
                unset($data[$key]);
                unset($debt[$key]);
            }
        }
        return view('admin.reports.calculate', [
            'data' => $data,
            'years' => $years,
            'debt' => $debt,
        ]);
    }

//    public function calculate(Request $request)
//    {
//        $table = 'reports_' . Auth::id();
//        $year = $request->input('year');
//        $years = DB::table($table)->distinct('year')->pluck('year');
//
//        if ($year == null) {
//            $year = $years->first();
//        }
//
//        $reports = DB::table($table)
//            ->select('*')
//            ->where('year', $year)
//            ->get();
//
//        $data = $reports->groupBy(function ($report) {
//            return $report->dt;
//        })->map(function ($group) {
//            return [
//                'data' => $group,
//                'dt_weight' => $group->sum('weight'),
//                'kt_weight' => 0,
//                'dt_price' => $group->sum('price'),
//                'kt_price' => 0,
//            ];
//        })->toArray();
//
//        foreach ($reports->groupBy('kt') as $key => $group) {
//            if (isset($data[$key])) {
//                $data[$key]['kt_weight'] = $group->sum('weight');
//                $data[$key]['kt_price'] = $group->sum('price');
//            } else {
//                $data[$key] = [
//                    'data' => $group,
//                    'dt_weight' => 0,
//                    'kt_weight' => $group->sum('weight'),
//                    'dt_price' => 0,
//                    'kt_price' => $group->sum('price'),
//                ];
//            }
//        }
//
//        ksort($data);
//
//        if ($request->has('dtkt')) {
//            $dtkt = $request->input('dtkt');
//            $data = array_intersect_key($data, array_flip($dtkt));
//        }
//
//        return view('admin.reports.calculate', compact('data', 'years'));
//    }


    public function index(Request $request)
    {
        $year = $request['year'];
        $month = $request['month'];
        $n_id = $request['n_id'];
        $table = 'reports_'.Auth::id();

        $query = DB::table($table)->select('*');

        if ($year != null) {
            $query->where('year', $year);
        }

        if ($month != null) {
            $query->where('month', $month);
        }

        if ($n_id != null) {
            $query->where('n_id', $n_id);
        }

        $reports = $query->get();

        $years = DB::table($table)->select('year')->distinct()->get();

        return view('admin.reports.index', compact('reports', 'years', 'year', 'month', 'n_id', 'table'));
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
