<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $user = User::find($id);
        $table = 'reports_'.$user->id;
        if (!Schema::hasTable($table)) {
            Schema::create($table, function ($table) {
                $table->increments('id');
                $table->integer('n_id');
                $table->integer('year');
                $table->tinyInteger('month');
                $table->string('title');
                $table->integer('weight');
                $table->integer('dt');
                $table->integer('kt');
                $table->float('price', 10, 2);
                $table->timestamps();
            });
        }

        $table = 'debts_'.$user->id;
        if (!Schema::hasTable($table)) {
            Schema::create($table, function ($table) {
                $table->increments('id');
                $table->integer('year');
                $table->integer('dtkt');
                $table->integer('dt_weight');
                $table->float('dt_price', 10, 2);
                $table->integer('kt_weight');
                $table->float('kt_price', 10, 2);
                $table->timestamps();
            });
        }

        $user->table = $table;
        $user->status = ! $user->status;
        $user->save();

        return redirect()->back();
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        Schema::dropIfExists('reports_'.$user->id);
        $user->delete();
        return redirect()->back();
    }
}
