<?php

namespace App\Http\Controllers;

use App\OrderItem;
use App\Log;
use Illuminate\Http\Request;
use Session;
use App\Order;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $this->validate($request, [
            'qty' => 'required',
        ]);
        $order_id = $request->input('order_id');
        $product_id = $request->input('product_id');
        $item = OrderItem::where('order_id', $order_id)
            ->where('product_id', $product_id)
            ->first();
        if ($item) {
            $item->order_id = $order_id;
            $item->qty = $item->qty + $request->input('qty');
            $item->save();
        } else {
            $item = new OrderItem;
            $item->order_id = $order_id;
            $item->product_id = $product_id;
            $item->qty = $request->input("qty");
            $item->save();
        }
        // update Total price
        $items = OrderItem::where('order_id', $item->order_id)->get();
        $total = 0;
        foreach ($items as $item) {
            $total = $total + ($item->product->price * $item->qty);
        }

        $order = Order::where('id', $item->order_id)->first();
        $order->total_price = $total;
        $order->save();

        Session::flash("success", "berhasil menambah data");
        Log::desc('menambah order '  . $item->product->name);

        return redirect()->to('/order/' . $item->order_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = OrderItem::find($id);
        return view('item.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'qty' => 'required',
        ]);
        $item = OrderItem::find($id);
        $item->qty = $request->input("qty");
        $item->save();

        // update Total price
        $items = OrderItem::where('order_id', $item->order_id)->get();
        $total = 0;
        foreach ($items as $item) {
            $total = $total + ($item->product->price * $item->qty);
        }
        $order = Order::where('id', $item->order_id)->first();
        $order->total_price = $total;
        $order->save();

        Session::flash("success", "berhasil merubah data");
        Log::desc('mengubah order ' . $request->input('number') . ' ' . $item->product->name);

        return redirect()->to('/order/' . $item->order_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = OrderItem::find($id);

        $item->delete();
        $items = OrderItem::where('order_id', $item->order_id)->get();
        $total = 0;
        foreach ($items as $item) {
            $total = $total + ($item->product->price * $item->qty);
        }
        $order = Order::where('id', $item->order_id)->first();
        $order->total_price = $total;
        $order->save();

        Session::flash("success", "berhasil menghapus data");
        Log::desc('menghapus order ' . $item->order->order_number . ' ' . $item->product->name);

        return redirect()->to('/order/' . $item->order_id);
    }
}
