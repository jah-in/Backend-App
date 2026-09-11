<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    /**
     * Register a new admin.
     */
    #[OA\Post(
        path: "/api/admin/register",
        summary: "Register a new admin",
        tags: ["Admin Authentication"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name", "email", "password", "password_confirmation"],
                properties: [
                    new OA\Property(
                        property: "name",
                        type: "string",
                        example: "LibTrack Admin"
                    ),
                    new OA\Property(
                        property: "email",
                        type: "string",
                        format: "email",
                        example: "admin@libtrack.com"
                    ),
                    new OA\Property(
                        property: "password",
                        type: "string",
                        format: "password",
                        example: "password123"
                    ),
                    new OA\Property(
                        property: "password_confirmation",
                        type: "string",
                        format: "password",
                        example: "password123"
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Admin registered successfully"
            ),
            new OA\Response(
                response: 422,
                description: "Validation error"
            )
        ]
    )]
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin',
        ]);

        $token = $user->createToken('admin-token')->plainTextToken;

        return response()->json([
            'message' => 'Admin registered successfully.',
            'user' => $user,
            'token' => $token,
        ], 201);
    }


    /**
     * Login an admin.
     */
    #[OA\Post(
        path: "/api/admin/login",
        summary: "Login as admin",
        tags: ["Admin Authentication"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["email", "password"],
                properties: [
                    new OA\Property(
                        property: "email",
                        type: "string",
                        format: "email",
                        example: "admin@libtrack.com"
                    ),
                    new OA\Property(
                        property: "password",
                        type: "string",
                        format: "password",
                        example: "password123"
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Login successful"
            ),
            new OA\Response(
                response: 401,
                description: "Invalid credentials"
            ),
            new OA\Response(
                response: 403,
                description: "Unauthorized"
            )
        ]
    )]
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid email or password.'
            ], 401);
        }

        if ($user->role !== 'admin') {
            return response()->json([
                'message' => 'Unauthorized. Admin access only.'
            ], 403);
        }

        $token = $user->createToken('admin-token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful.',
            'user' => $user,
            'token' => $token,
        ]);
    }


    /**
     * Logout the authenticated admin.
     */
    #[OA\Post(
        path: "/api/admin/logout",
        summary: "Logout authenticated admin",
        tags: ["Admin Authentication"],
        security: [["sanctum" => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: "Logged out successfully"
            ),
            new OA\Response(
                response: 401,
                description: "Unauthenticated"
            )
        ]
    )]
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully.'
        ]);
    }


    /**
     * Get authenticated admin profile.
     */
    #[OA\Get(
        path: "/api/admin/profile",
        summary: "Get authenticated admin profile",
        tags: ["Admin Authentication"],
        security: [["sanctum" => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: "Admin profile retrieved successfully"
            ),
            new OA\Response(
                response: 401,
                description: "Unauthenticated"
            )
        ]
    )]
    public function profile(Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ]);
    }
}