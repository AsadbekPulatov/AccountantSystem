<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\DB;

class Report
{
    public function write($year, $month, $n_id, $table){
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
        return $reports;
    }

    public function calculate($year, $table){
        $query = DB::table($table)->select('*');

        if ($year != null) {
            $query->where('year', $year);
        }

        $reports = $query->get();
        $data = [];
        foreach($reports as $report){
            $data[$report->dt]['data'] = [];
            $data[$report->kt]['data'] = [];
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
        return $data;
    }
}
