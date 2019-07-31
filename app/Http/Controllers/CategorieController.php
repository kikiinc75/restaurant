<?php

namespace App\Http\Controllers;

use App\Categorie;
use App\Log;
use Illuminate\Http\Request;
use Session;
use App\Product;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list_categories = Categorie::paginate(2);
        return view('categorie.index', compact('list_categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categorie.create');
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

        $categorie = new Categorie;
        $categorie->name = $request->input('name');
        $categorie->save();
        Session::flash("success", "berhasil menyimpan database");
        Log::desc('menambah categorie ' . $categorie->name);

        return redirect()->route('categorie.index')->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function show(Categorie $categorie)
    { }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function edit(Categorie $categorie)
    {
        return view('categorie.edit', compact('categorie'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categorie $categorie)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $categorie->name = $request->input("name");
        $categorie->save();

        Session::flash("success", "berhasil merubah data");
        Log::desc('mengubah categorie ' . $categorie->name);

        return redirect()->route('categorie.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categorie $categorie)
    {
        $product = Product::where('categorie_id', $categorie->id);
        $product->delete();
        $categorie->delete();
        Session::flash("success", "berhasil dihapus");
        Log::desc('menghapus categorie ' . $categorie->name);
        Log::desc('menghapus product dalam categorie ' . $categorie->name);

        return back();
    }
}
