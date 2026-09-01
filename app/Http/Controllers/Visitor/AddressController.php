<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Get all saved addresses for the authenticated user.
     */
    public function index(Request $request): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        $addresses = auth()->user()->addresses()
            ->orderBy('is_default', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'addresses' => $addresses,
        ]);
    }

    /**
     * Store a newly created address for the authenticated user.
     */
    public function store(Request $request): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        $validated = $request->validate([
            'recipient_name' => ['required', 'string', 'max:255'],
            'contactNo' => ['required', 'string', 'max:20'],
            'address_line_1' => ['required', 'string', 'max:255'],
            'address_line_2' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'pincode' => ['required', 'string', 'max:20'],
            'type' => ['nullable', 'string', 'in:Home,Work,Other'],
            'is_default' => ['nullable', 'boolean'],
        ]);

        $user = auth()->user();
        $isFirst = $user->addresses()->count() === 0;
        $isDefault = $isFirst || !empty($validated['is_default']);

        if ($isDefault) {
            $user->addresses()->update(['is_default' => false]);
        }

        $address = $user->addresses()->create([
            'recipient_name' => $validated['recipient_name'],
            'contactNo' => $validated['contactNo'],
            'address_line_1' => $validated['address_line_1'],
            'address_line_2' => $validated['address_line_2'] ?? null,
            'city' => $validated['city'],
            'state' => $validated['state'],
            'pincode' => $validated['pincode'],
            'type' => $validated['type'] ?? 'Home',
            'is_default' => $isDefault,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Address saved successfully!',
            'address' => $address,
            'addresses' => $user->addresses()->orderBy('is_default', 'desc')->orderBy('id', 'desc')->get(),
        ], 201);
    }

    /**
     * Update the specified address.
     */
    public function update(Request $request, Address $address): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        if ($address->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized action.'], 403);
        }

        $validated = $request->validate([
            'recipient_name' => ['required', 'string', 'max:255'],
            'contactNo' => ['required', 'string', 'max:20'],
            'address_line_1' => ['required', 'string', 'max:255'],
            'address_line_2' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'pincode' => ['required', 'string', 'max:20'],
            'type' => ['nullable', 'string', 'in:Home,Work,Other'],
            'is_default' => ['nullable', 'boolean'],
        ]);

        $user = auth()->user();
        $isDefault = !empty($validated['is_default']);

        if ($isDefault && !$address->is_default) {
            $user->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
        }

        $address->update([
            'recipient_name' => $validated['recipient_name'],
            'contactNo' => $validated['contactNo'],
            'address_line_1' => $validated['address_line_1'],
            'address_line_2' => $validated['address_line_2'] ?? null,
            'city' => $validated['city'],
            'state' => $validated['state'],
            'pincode' => $validated['pincode'],
            'type' => $validated['type'] ?? $address->type,
            'is_default' => $isDefault ? true : $address->is_default,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Address updated successfully!',
            'address' => $address->fresh(),
            'addresses' => $user->addresses()->orderBy('is_default', 'desc')->orderBy('id', 'desc')->get(),
        ]);
    }

    /**
     * Set the specified address as default.
     */
    public function setDefault(Address $address): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        if ($address->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized action.'], 403);
        }

        $user = auth()->user();
        $user->addresses()->update(['is_default' => false]);
        $address->update(['is_default' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Default address set successfully!',
            'address' => $address->fresh(),
            'addresses' => $user->addresses()->orderBy('is_default', 'desc')->orderBy('id', 'desc')->get(),
        ]);
    }

    /**
     * Remove the specified address from database.
     */
    public function destroy(Address $address): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        if ($address->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized action.'], 403);
        }

        $user = auth()->user();
        $wasDefault = $address->is_default;
        $address->delete();

        if ($wasDefault) {
            $nextDefault = $user->addresses()->latest()->first();
            if ($nextDefault) {
                $nextDefault->update(['is_default' => true]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Address deleted successfully!',
            'addresses' => $user->addresses()->orderBy('is_default', 'desc')->orderBy('id', 'desc')->get(),
        ]);
    }
}
