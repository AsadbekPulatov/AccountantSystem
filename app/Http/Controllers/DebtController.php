<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DebtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $table = 'debts_'.Auth::id();
        $debts = DB::table($table)->orderBy('year', 'DESC')->get();
        $sum['dt_price'] = 0;
        $sum['kt_price'] = 0;
        foreach ($debts as $debt){
            $sum['dt_price']+=$debt->dt_price;
            $sum['kt_price']+=$debt->kt_price;
        }
        return view('admin.debts.index', compact('debts','sum'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.debts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $table = 'debts_'.Auth::id();
        $request['dt_price'] = str_replace(',','.', $request['dt_price']);
        $request['kt_price'] = str_replace(',','.', $request['kt_price']);
        DB::table($table)->insert([
            'dtkt' => $request->dtkt,
            'year' => $request->year,
            'dt_weight' => $request->dt_weight,
            'dt_price' => $request->dt_price,
            'kt_weight' => $request->kt_weight,
            'kt_price' => $request->kt_price,
        ]);
        return redirect()->route('debts.index')->with('success', 'Debt created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $table = 'debts_'.Auth::id();
        $debt = DB::table($table)->where('id', $id)->first();
        return view('admin.debts.edit', compact('debt'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $table = 'debts_'.Auth::id();
        $request['dt_price'] = str_replace(',','.', $request['dt_price']);
        $request['kt_price'] = str_replace(',','.', $request['kt_price']);
        DB::table($table)->where('id', $id)->update([
            'dtkt' => $request->dtkt,
            'year' => $request->year,
            'dt_weight' => $request->dt_weight,
            'dt_price' => $request->dt_price,
            'kt_weight' => $request->kt_weight,
            'kt_price' => $request->kt_price,
        ]);
        return redirect()->route('debts.index')->with('success', 'Debt updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $table = 'debts_'.Auth::id();
        DB::table($table)->where('id', $id)->delete();
        return redirect()->route('debts.index')->with('success', 'Debt deleted successfully.');
    }
}
