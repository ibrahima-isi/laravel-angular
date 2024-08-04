<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $validatedData['email_verified_at'] = now();
            $validatedData['password'] = bcrypt($validatedData['password']);

            $user = User::create($validatedData);
            return response()->json($user, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'echec de creation.', 'error' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $user = User::findOrFail($id);
            return response()->json($user, 200);
        }catch (ModelNotFoundException $exception){
            return response()->json(['message' => 'User not found.', 'error' => $exception->getMessage()], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     * @throws \Exception
     */
    public function update(UserRequest $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
            if($request->has('email')){
                $request->merge(['email_verified_at' => now()]);
            }
            if($request->has('password')){
                $request->merge(['password' => bcrypt($request->password)]);
            }
            $user->update($request->all());
            return response()->json($user, 200);
        }catch (ModelNotFoundException $exception){
            return response()->json(['message' => 'User not found.', 'error' => $exception->getMessage()], 404);
        }catch (\Exception $exception){
            return response()->json(['message' => 'Validation failed, User not updated.', 'error' => $exception->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json(null, 204);
        }catch (ModelNotFoundException $exception){
            return response()->json(['message' => 'User not found.', 'error' => $exception->getMessage()], 404);
        }
    }
}
