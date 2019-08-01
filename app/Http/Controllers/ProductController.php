<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Log;
use App\Categorie;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Log::desc('melihat product');
        $products = Product::paginate(5);
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $list_categories = Categorie::all();
        return view('product.create', compact('list_categories'));
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
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1000',
            'name' => 'required',
            'price' => 'required|integer',
            'categorie_id' => 'required|integer'
        ]);

        $product = new Product;
        $product->name          = $request->input("name");
        $product->price         = $request->input("price");
        $product->categorie_id  = $request->input("categorie_id");
        $product->save();

        //upload file to storage
        if ($request->file('image') != null) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $newName = rand(100000, 1001238912) . "." . $ext;
            $file->move('uploads/file', $newName);
            $product->image = $newName;
            $product->save();
        }

        Session::flash("success", "berhasil save data");
        Log::desc('menambah product ' . $product->name);

        return redirect()->to('product');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $list_categories = Categorie::all();
        return view("product.edit", compact('product', 'list_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required|integer',
            'categorie_id' => 'required|integer',
            'status' => 'required|integer'
        ]);

        $product->name = $request->input("name");
        $product->price = $request->input("price");
        $product->categorie_id = $request->input("categorie_id");
        $product->status = $request->input("status");
        $product->save();

        Session::flash("success", "berhasil update data");
        Log::desc('mengubah product ' . $product->name);

        return redirect()->to('product');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        Session::flash("success", "berhasil menghapus data");
        Log::desc('menghapus product ' . $product->name);

        return back();
    }
}
