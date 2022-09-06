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
            $data = $request->all();
            return $data->id;
            // $data = Order::find($request->id);
            // $data->customer_name = $request->customer_name;
            // $data->customer_contact = $request->customer_contact;
            // $data->customer_email = $request->customer_email;
            // $data->customer_address = $request->customer_address;
            // $data->flavor = $request->flavor;
            // $data->size = $request->size;
            // $$data->delivery_time = $request->delivery_time;
            // $data->remarks = $request->customer_name;
            // return $data;
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
            return response()->json([
                'status' => 'Order added',
                'data' => $order
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
        return response()->json([
            'status' => 'Order deleted',
        ], 200);
    }
}
