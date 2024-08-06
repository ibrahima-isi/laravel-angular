<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json(['message' => 'Orders fetched successfully', 'orders' => Order::all()], 200);
        }catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching orders',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {
        try {
            $order = $request->all();
            $order['date_order'] = now()->toDateTime();
            Order::create($order);
            return response()->json(['message' => 'Order created successfully', 'order' => $order], 201);
        }catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while creating order', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $order = Order::findOrFail($id);
            return response()->json(['message' => 'Order fetched successfully', 'order' => $order], 200);
        }catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Order not found', 'error' => $e->getMessage()], 404);
        }catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while fetching order', 'error' => $e->getMessage()], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderRequest $request, string $id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->update($request->all());
            return response()->json(['message' => 'Order updated successfully', 'order' => $order], 200);
        }catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Order not found', 'error' => $e->getMessage()], 404);
        }
        catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while updating order', 'error' => $e->getMessage()], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();
            return response()->json(['message' => 'Order deleted successfully', 'deleted order' => $order], 200);
        }catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Order not found', 'error' => $e->getMessage()], 404);
        }catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while deleting order', 'error' => $e->getMessage()], 404);
        }
    }
}
