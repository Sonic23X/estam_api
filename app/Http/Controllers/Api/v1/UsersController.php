<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\AssignPropertyToStockholder;
use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\UsersComboResource;
use App\Http\Resources\PropertyResource;
use App\Models\User;
use App\Models\Property;
use App\Models\PropertyStockholder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'users' => UserResource::collection(User::all())
        ]);
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
    public function store(CreateUserRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'second_last_name' => $request->second_last_name,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => Hash::make($request->password),
        ]);

        if ($request->type === 0) {
            $user->assignRole(User::TYPE_SUPER_ADMIN);
        } else if ($request->type === 2) {
            $user->assignRole(User::TYPE_USER);
        }

        return response()->json(['message' => 'User created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid): JsonResponse
    {
        $user = User::where('uuid', $uuid)->first();

        if ($user == null) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        return response()->json(['user' => new UserResource($user)], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $uuid): JsonResponse
    {
        $user = User::where('uuid', $uuid)->first();

        if ($user == null) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        if ($request->type === 0) {
            $user->syncRoles(User::TYPE_SUPER_ADMIN);
        } else if ($request->type === 2) {
            $user->syncRoles(User::TYPE_USER);
        }

        $user->update([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'second_last_name' => $request->second_last_name,
            'email' => $request->email,
            'telephone' => $request->telephone,
        ]);

        return response()->json(['message' => 'User updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $user = User::where('uuid', $id)->first();

        if ($user == null) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }

    function usersCombo($type = null): JsonResponse {
        $users = User::with('roles')->get();

        if ($type != null) {
            if ($type == 1) {
                $users = $users->filter(function ($user) {
                    return $user->hasRole(User::TYPE_PARTNER) || $user->hasRole(User::TYPE_SUPER_ADMIN);
                });
            }
        }

        return response()->json(['users' => UsersComboResource::collection($users)], 200);
    }
}
