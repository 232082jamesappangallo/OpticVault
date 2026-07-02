<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ItemController extends Controller
{
    /**
     * Display a listing of items
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 10);
            $items = Item::orderBy('created_at', 'desc')->paginate($perPage);

            return response()->json([
                'message' => 'Items retrieved successfully',
                'data' => $items->items(),
                'pagination' => [
                    'current_page' => $items->currentPage(),
                    'per_page' => $items->perPage(),
                    'total' => $items->total(),
                    'last_page' => $items->lastPage(),
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve items',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get recent items (for dashboard)
     */
    public function recent(Request $request)
    {
        try {
            $limit = $request->query('limit', 3);
            $items = Item::orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();

            return response()->json([
                'message' => 'Recent items retrieved successfully',
                'data' => $items
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve recent items',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created item
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'category' => 'required|string|max:100',
                'quantity' => 'required|integer|min:0',
                'location' => 'nullable|string|max:255',
                'condition' => 'nullable|in:Baik,Rusak,Perlu Perbaikan',
            ]);

            $item = Item::create($validated);

            return response()->json([
                'message' => 'Item created successfully',
                'data' => $item
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create item',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified item
     */
    public function show(Item $item)
    {
        try {
            return response()->json([
                'message' => 'Item retrieved successfully',
                'data' => $item
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Item not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified item
     */
    public function update(Request $request, Item $item)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'category' => 'required|string|max:100',
                'quantity' => 'required|integer|min:0',
                'location' => 'nullable|string|max:255',
                'condition' => 'nullable|in:Baik,Rusak,Perlu Perbaikan',
            ]);

            $item->update($validated);

            return response()->json([
                'message' => 'Item updated successfully',
                'data' => $item
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update item',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified item
     */
    public function destroy(Item $item)
    {
        try {
            $item->delete();

            return response()->json([
                'message' => 'Item deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete item',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get items by category (filter)
     */
    public function getByCategory(Request $request, $category)
    {
        try {
            $items = Item::where('category', $category)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'message' => 'Items retrieved successfully',
                'data' => $items
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve items',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
