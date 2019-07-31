<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use App\Product;
use Auth;
use App\Cart;
use App\Table;
use App\OrderItem;

class OrderController extends Controller
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where('status', 1)->paginate(10);
        return view('order.active', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tables = Table::where('status', 1)->get();
        $products = Product::where('status', 1)->get();
        return view('order.add', compact('products', 'tables'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Order
        $order = new Order;
        $order->user_id = Auth::user()->id;
        $order->table_id = $request->input('table_id');
        $order->order_number = 0;
        $order->total_price = $request->input('total_price');
        $order->save();

        //perintah update
        $newOrder = Order::find($order->id);
        $newOrder->order_number = ('ERP' . date('dmY') . '-' . $order->id);
        $newOrder->save();

        $carts = Cart::where('user_id', Auth::user()->id)->get();
        foreach ($carts as $cart) {
            $item = new OrderItem;
            $item->order_id = $order->id;
            $item->product_id = $cart->product_id;
            $item->qty = $cart->qty;
            $item->save();
        }

        $oldcart = Cart::where('user_id', Auth::user()->id);
        $oldcart->delete();
        $table = Table::where('id', $order->table_id)->first();
        $table->status = 0;
        $table->save();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        return view('order.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::find($id);
        return view('order.pay', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        $order->status = 0;
        $order->save();

        $table = Table::where('id', $order->table_id)->first();
        $table->status = 1;
        $table->save();

        return redirect('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
