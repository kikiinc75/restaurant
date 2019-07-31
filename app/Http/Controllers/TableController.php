<?php

namespace App\Http\Controllers;

use App\Table;
use App\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tables = Table::paginate(5);
        return view('table.index', compact('tables'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('table.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:20'
        ]);

        $table = new Table;
        $table->name = $request->input('name');
        $table->save();
        Session::flash("success", "berhasil menyimpan database");
        Log::desc('menambah table ' . $table->name);

        return redirect()->route('table.index')->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function show(Table $table)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function edit(Table $table)
    {
        return view('table.edit', compact('table'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Table $table)
    {
        $this->validate($request, [
            'name' => 'required|string|max:20',
            'status' => 'required|integer'
        ]);

        $table->name = $request->input('name');
        $table->status = $request->input('status');
        $table->save();

        Session::flash("success", "berhasil mengubah database");
        Log::desc('mengubah table ' . $table->name);

        return redirect()->route('table.index')->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function destroy(Table $table)
    {
        $table->delete();
        Session::flash("success", "berhasil dihapus");
        Log::desc('menghapus Table ' . $table->name);

        return back();
    }
}
