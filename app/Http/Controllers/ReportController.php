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
    public function index()
    {
        $table = Auth::user()->table;
        if ($table != null) {
            $reports = DB::table($table)->select('*')->get();
            return view('admin.reports.index', compact('reports'));
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
        $table = Auth::user()->table;
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
        $table = Auth::user()->table;
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
        $table = Auth::user()->table;
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
        $table = Auth::user()->table;
        DB::table($table)->where('id', $id)->delete();
        return redirect()->route('reports.index')->with('success', 'Report deleted successfully');
    }
}
