<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ReviewController extends Controller
{
    /**
     * 1. Display list of all customer reviews (READ)
     */
    public function index(): View
    {
        $reviews = Review::with('product')->latest()->get();
        return view('admin.pages.reviews.index', compact('reviews'));
    }

    /**
     * 2. Show form to create a new review (CREATE)
     */
    public function create(): View
    {
        $products = Product::orderBy('name')->get();
        return view('admin.pages.reviews.create', compact('products'));
    }

    /**
     * 3. Save new review in database with optional photo upload (STORE)
     */
    public function store(Request $request): RedirectResponse
    {
        // Simple Form Validation
        $request->validate([
            'author'     => 'required|string|max:255',
            'location'   => 'nullable|string|max:255',
            'product_id' => 'nullable|exists:products,id',
            'rating'     => 'required|integer|min:1|max:5',
            'comment'    => 'required|string',
            'photo'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'     => 'required|string|in:Approved,Pending,Hidden',
        ]);

        $data = [
            'author'     => $request->author,
            'location'   => $request->location,
            'product_id' => $request->product_id,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
            'status'     => $request->status,
        ];

        // Upload Reviewer Photo if provided
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('reviews/photos', 'public');
        }

        // Create review record in database
        Review::create($data);

        return redirect()->route('admin.reviews.index')->with('success', 'Customer review added successfully!');
    }

    /**
     * 4. Show form to edit an existing review (EDIT)
     */
    public function edit(Review $review): View
    {
        $products = Product::orderBy('name')->get();
        return view('admin.pages.reviews.edit', compact('review', 'products'));
    }

    /**
     * 5. Update existing review in database (UPDATE)
     */
    public function update(Request $request, Review $review): RedirectResponse
    {
        // Simple Form Validation
        $request->validate([
            'author'     => 'required|string|max:255',
            'location'   => 'nullable|string|max:255',
            'product_id' => 'nullable|exists:products,id',
            'rating'     => 'required|integer|min:1|max:5',
            'comment'    => 'required|string',
            'photo'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'     => 'required|string|in:Approved,Pending,Hidden',
        ]);

        $data = [
            'author'     => $request->author,
            'location'   => $request->location,
            'product_id' => $request->product_id,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
            'status'     => $request->status,
        ];

        // If new Photo uploaded, delete old one and store new one
        if ($request->hasFile('photo')) {
            if ($review->photo && Storage::disk('public')->exists($review->photo)) {
                Storage::disk('public')->delete($review->photo);
            }
            $data['photo'] = $request->file('photo')->store('reviews/photos', 'public');
        }

        // Update review in database
        $review->update($data);

        return redirect()->route('admin.reviews.index')->with('success', 'Customer review updated successfully!');
    }

    /**
     * 6. Delete a review from database and remove its photo (DELETE)
     */
    public function destroy(Review $review): RedirectResponse
    {
        // Delete image file from storage if present
        if ($review->photo && Storage::disk('public')->exists($review->photo)) {
            Storage::disk('public')->delete($review->photo);
        }

        // Delete from database
        $review->delete();

        return redirect()->route('admin.reviews.index')->with('success', 'Customer review deleted successfully!');
    }
}
