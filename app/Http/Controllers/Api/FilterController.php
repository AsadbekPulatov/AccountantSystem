<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FilterController extends Controller
{
    public function selectYear(Request $request)
    {
        $table = $request->table;
        $year = $request->year;
        $months = DB::table($table)->select('month')->where('year', $year)->distinct()->get();
        return response()->json($months);
    }

    public function selectMonth(Request $request)
    {
        $table = $request->table;
        $year = $request->year;
        $month = $request->month;
        $reports = DB::table($table)->select('n_id')->where('year', $year)->where('month', $month)->distinct()->get();
        return response()->json($reports);
    }

    public function findDtKt(Request $request){
        $table = $request->table;
        $year = $request->year;
        $reports = DB::table($table)->select('dt', 'kt')->where('year', $year)->get();
        $array = [];
        foreach($reports as $report){
            $array[] = $report->dt;
            $array[] = $report->kt;
        }
        $reports = array_unique($array);
        sort($reports);
        return response()->json($reports);
    }

    public function filter(Request $request)
    {
        $table = $request->table;
        $year = $request->year;
        $month = $request->month;
        $n_id = $request->n_id;
        $reports = DB::table($table)->select('*')->where('year', $year)->where('month', $month)->where('n_id', $n_id)->get();
        return response()->json($reports);
    }
}
