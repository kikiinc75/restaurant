<?php

namespace App\Http\Controllers;

use App\Product;
use App\Cart;
use Auth;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function apiMakanan()
    {
        $products = Product::where('status', 1)->get();
        return response()->json($products);
    }
    public function getCart()
    {
        $array = [];
        $cart = Cart::where('user_id', Auth::id())->orderBy('id', 'desc')->get();
        foreach ($cart as $data) {
            $array[] = array("id" => $data->id, "product" => $data->product->name, "price" => $data->product->price, "qty" => $data->qty);
        }
        return response()->json($array);
    }
    public function addToCart(Request $request)
    {
        $user = $request->input("user_id");
        $product_id = $request->input("product_id");
        $cart = Cart::where('user_id', $user)->where('product_id', $product_id)->first();
        if ($cart) {
            // Update input qty
            $cart->qty = $cart->qty + 1;
            $product = $cart->product_id;
        } else {
            // Input new Cart
            $cart = new Cart;
            $cart->user_id = $user;
            $product = $cart->product_id = $product_id;
            $cart->qty = 1;
        }
        $cart->save();
        $array = array("product_id" => $product_id);
        return response()->json($array);
    }
    public function removeCart($id)
    {
        $cart = Cart::find($id);
        $cart->delete();
    }
}
