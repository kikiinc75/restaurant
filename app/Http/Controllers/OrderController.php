<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use App\Product;
use Auth;
use App\Cart;
use App\Table;
use App\OrderItem;
use App\Log;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where('status', 1)->paginate(10);
        return view('order.index', compact('orders'));
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
        return view('order.create', compact('products', 'tables'));
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
            'table_id' => 'required|integer',
        ]);

        $carts = Cart::where('user_id', Auth::user()->id)->get();

        $total = 0;
        foreach ($carts as $cart) {
            $total = $total + ($cart->qty * $cart->product->price);
        }

        // Order
        $order = new Order;
        $order->user_id = Auth::user()->id;
        $order->table_id = $request->input('table_id');
        $order->order_number = 0;
        $order->total_price = $total;
        $order->save();

        //perintah update
        $newOrder = Order::find($order->id);
        $newOrder->order_number = ('ERP' . date('dmY') . '-' . $order->id);
        $newOrder->save();

        // menambah Daftar cart ke OrderItem
        foreach ($carts as $cart) {
            $item = new OrderItem;
            $item->order_id = $order->id;
            $item->product_id = $cart->product_id;
            $item->qty = $cart->qty;
            $item->save();
        }

        // Delete Cart setelah dimasukkan ke OrderItem
        $oldcart = Cart::where('user_id', Auth::user()->id);
        $oldcart->delete();

        $table = Table::where('id', $order->table_id)->first();
        $table->status = 0;
        $table->save();
        Log::desc('menambah order baru '  . $newOrder->order_number);

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
        $products = Product::where('status', 1)->get();
        return view('order.show', compact('order', 'products', 'id'));
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
        return view('order.edit', compact('order'));
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
        $this->validate($request, [
            'pay' => 'required|integer',
        ]);

        $order = Order::find($id);
        $order->status = 0;
        $order->save();

        $table = Table::where('id', $order->table_id)->first();
        $table->status = 1;
        $table->save();
        Log::desc('menerima pembayaran order '  . $order->order_number);

        return redirect('order');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        $table = Table::where('id', $order->table_id)->first();
        $table->status = 1;
        $table->save();

        Log::desc('membatalkan orderan '  . $order->order_number);
        $order->delete();
        return back();
    }
}
