<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Payment;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $payments = Payment::all();
            if(isEmpty($payments)){
                throw new ModelNotFoundException();
            }
            return response()->json($payments, 200);
        }catch (ModelNotFoundException $exception){
            return response()->json([
                'message' => 'No payments found',
            ], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentRequest $request)
    {
        try{
            $payment = Payment::create($request->all());
            $payment['payment_date'] = now()->toDateTime();
            return response()->json(['message' => 'Payment created successfully' , $payment], 201);
        }catch (Exception $exception){
            return response()->json([
                'message' => 'Payment not created',
                'error' => $exception->getMessage(),
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $payment = Payment::findOrFail($id);
            return response()->json($payment, 200);
        }catch (ModelNotFoundException $exception){
            return response()->json([
                'message' => 'Payment not found',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $payment = Payment::findOrFail($id);
            $payment->update($request->all());
            return response()->json(['message' => 'Payment updated successfully' , $payment], 200);
        }catch (ModelNotFoundException $exception){
            return response()->json([
                'message' => 'Payment not found for update',
            ], 404);
        }catch (Exception $exception){
            return response()->json([
                'message' => 'Payment not updated',
                'error' => $exception->getMessage(),
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $payment = Payment::findOrFail($id);
            $payment->delete();
            return response()->json(['message' => 'Payment deleted successfully', 'deleted payment' => $payment], 200);
        }catch (ModelNotFoundException $exception){
            return response()->json([
                'message' => 'Payment not found for delete',
                'error' => $exception->getMessage(),
            ], 404);
        }
    }
}
