<?php

namespace App\Http\Controllers;

use App\Http\Requests\BurgerRequest;
use App\Models\Burger;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BurgerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $burgers = Burger::all();
            return response()->json(['burgers' => $burgers], 200);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Burgers not found'], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BurgerRequest $request)
    {
        try {
            $burger = $request->all();
            if($request->hasFile('image')){
                $request->validate([
                    'image' => 'mimes:jpeg,jpg,png,gif|required|max:10000'
                ]);
                // gerer l'image:
                $image = $request->file('image');
                $imageName = now()->toDateString() . "-" . $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);
                $burger['image'] = $imageName;
            }
            Burger::create($burger);
            return response()->json(['message' => 'Burger created successfully', 'burger' => $burger], 201);
        }catch (\Exception $exception){
            return response()->json(['message' => 'Burger creation failed !', 'error' => $exception->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $burger = Burger::findOrFail($id);
            return response()->json(['burger' => $burger], 200);
        }catch (ModelNotFoundException $exception){
            return response()->json(['message' => 'Burger not found', "error message" => $exception->getMessage()], 404);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(BurgerRequest $request, string $id)
    {
        try {
            $burger = Burger::findOrFail($id);
            $validatedData = $request->all();

            // Check if a new image is uploaded
            if ($request->hasFile('image')) {
                // Delete the old image
                $oldImage = public_path('images') . '/' . $burger->image;
                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }

                // Handle the new image
                $imageName = now() . "-" . $request->image->getClientOriginalName();
                $request->image->move(public_path('images'), $imageName);
                $validatedData['image'] = $imageName;
            }

            // Update the burger with the new data
            $burger->update($validatedData);

            return response()->json(['message' => 'Burger updated successfully', 'updated burger' => $validatedData], 200);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Burger update failed!', 'error message' => $exception->getMessage()], 400);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $burger = Burger::findOrFail($id);
            $burger->delete();
            return response()->json(['message' => 'Burger deleted successfully', 'deleted burger' => $burger], 200);
        }catch (ModelNotFoundException $exception){
            return response()->json(['message' => 'Burger not found', "error" => $exception->getMessage()], 404);
        }
    }
}
