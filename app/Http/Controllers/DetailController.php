<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OrderItem;

class DetailController extends Controller
{
    public function edit($id)
    {
        $item = OrderItem::find($id);
        return view('detail.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = OrderItem::find($id)->delete();
        return back();
    }
}
