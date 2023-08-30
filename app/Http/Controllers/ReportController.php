<?php

namespace App\Http\Controllers;

use App\Http\Services\Report;
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
        $report = new Report();

        $dtkt = $request['dtkt'];
        $year = $request['year'];

        $table = 'reports_'.Auth::id();

        $years = DB::table($table)->distinct('year')->pluck('year');
        if ($year == null)
            $year = $years->first();
        $data = $report->calculate($year, $table);

        $table = 'debts_'.Auth::id();
        $debts = DB::table($table)->select('*')->where('year', $year)->get();
        $debt = [];
        foreach ($debts as $item){
            $debt[$item->dtkt] = $item;
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
            'year' => $year,
            'dtkt' => $dtkt,
        ]);
    }

    public function index(Request $request)
    {
        $report = new Report();
        $year = $request['year'];
        $month = $request['month'];
        $n_id = $request['n_id'];
        $table = 'reports_'.Auth::id();
        $reports = $report->write($year, $month, $n_id, $table);
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
                'weight' => $request['weight'][$i] ?? 0,
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
