<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Addon;
use App\Models\OrderAddon;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Order::with('addons')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->isMethod('put')){
            $findOrderAddon = OrderAddon::where('order_id', $request->order_id)->get();
            foreach($findOrderAddon as $addon){
                $rmExistingAddon = OrderAddon::find($addon->id);
                $rmExistingAddon->delete();
            }
            $order = Order::with('addons')->find($request->order_id);
            $order->customer_name = $request->input('customer_name');
            $order->customer_contact = $request->input('customer_contact');
            $order->customer_email = $request->input('customer_email');
            $order->customer_address = $request->input('customer_address');
            $order->flavor = $request->input('flavor');
            $order->size = $request->input('size');
            $order->delivery_time = $request->input('delivery_time');
            $order->remarks = $request->input('customer_name');
            foreach($request->addons as $newAddon){
                $addNewAddon = new OrderAddon;
                $addNewAddon->order_id = $order->id;
                $addNewAddon->addon_id = $newAddon;
                $addNewAddon->save();
            }
            $order->save();
            return response()->json([
                'status' => 'Order updated',
                'data' => $order
            ], 200);
        }
        else{
            $data = $request->all();
            $order = Order::create($data);
            foreach($request->addons as $addon){
                $add =  new OrderAddon;
                $add->order_id = $order->id;
                $add->addon_id = $addon;
                $add->save();
            }
            $newData = Order::with('addons')->orderBy('created_at', 'desc')->first();
            return response()->json([
                'status' => 'Order added',
                'data' => $newData
            ], 200);
        }
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
        //
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
        $addons = OrderAddon::where('order_id', $id)->get();
        foreach($addons as $addon){
            $rmOrderAddon = OrderAddon::find($addon->id);
            $rmOrderAddon->delete();
        }
        $rmOrder = Order::find($id);
        $rmOrder->delete();
        return Order::with('addons')->get();
    }
}
