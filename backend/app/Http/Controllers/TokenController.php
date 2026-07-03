<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TokenController extends Controller
{
    /**
     * Get all tokens for current user
     */
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            $tokens = $user->tokens()->get();

            return response()->json([
                'message' => 'Tokens retrieved successfully',
                'data' => $tokens->map(function ($token) {
                    return [
                        'id' => $token->id,
                        'name' => $token->name,
                        'last_used_at' => $token->last_used_at,
                        'created_at' => $token->created_at,
                        'expires_at' => $token->expires_at,
                        'abilities' => $token->abilities,
                    ];
                }),
                'total' => $tokens->count(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve tokens',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Revoke a specific token
     */
    public function revoke(Request $request, $tokenId)
    {
        try {
            $user = $request->user();
            $token = $user->tokens()->find($tokenId);

            if (!$token) {
                return response()->json([
                    'message' => 'Token not found',
                ], 404);
            }

            $token->delete();

            return response()->json([
                'message' => 'Token revoked successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to revoke token',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Revoke all tokens for current user
     */
    public function revokeAll(Request $request)
    {
        try {
            $user = $request->user();
            $user->tokens()->delete();

            return response()->json([
                'message' => 'All tokens revoked successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to revoke all tokens',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get current token info
     */
    public function current(Request $request)
    {
        try {
            $token = $request->user()->currentAccessToken();

            if (!$token) {
                return response()->json([
                    'message' => 'No current token',
                ], 404);
            }

            return response()->json([
                'message' => 'Current token info',
                'data' => [
                    'id' => $token->id,
                    'name' => $token->name,
                    'last_used_at' => $token->last_used_at,
                    'created_at' => $token->created_at,
                    'expires_at' => $token->expires_at,
                    'abilities' => $token->abilities,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to get current token',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
