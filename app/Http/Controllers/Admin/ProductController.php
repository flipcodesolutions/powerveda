<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductFaq;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * 1. Display list of all products (READ)
     */
    public function index(): View
    {
        $products = Product::withCount(['reviews', 'faqs'])->latest()->get();
        return view('admin.pages.products.index', compact('products'));
    }

    /**
     * 2. Show form to create a new product (CREATE)
     */
    public function create(): View
    {
        return view('admin.pages.products.create');
    }

    /**
     * 3. Save new product in database with file upload (STORE)
     */
    public function store(Request $request): RedirectResponse
    {
        // Form Validation
        $request->validate([
            'name'           => 'required|string|max:255',
            'price'          => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'discount'       => 'nullable|string|max:50',
            'badge'          => 'nullable|string|max:50',
            'stock'          => 'required|integer|min:0',
            'photo'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'detail'         => 'nullable|string',
            'how_to_use'     => 'nullable|string',
            'meta_title'     => 'nullable|string|max:255',
            'meta_detail'    => 'nullable|string',
            'og_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Process structured How-To-Use Steps if provided
        $steps = $this->parseSteps($request);

        $data = [
            'name'             => $request->name,
            'price'            => $request->price,
            'original_price'   => $request->original_price,
            'discount'         => $request->discount,
            'stock'            => $request->stock,
            'detail'           => $request->detail,
            'how_to_use'       => $request->how_to_use,
            'how_to_use_steps' => count($steps) > 0 ? $steps : null,
            'badge'            => $request->filled('badge') ? $request->badge : 'NATURAL',
            'meta_title'       => $request->filled('meta_title') ? $request->meta_title : $request->name,
            'meta_detail'      => $request->filled('meta_detail') ? $request->meta_detail : $request->detail,
        ];

        // 1. Upload Product Photo
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('products/photos', 'public');
        }

        // 2. Upload OG Social Image (if not uploaded, use the same product photo)
        if ($request->hasFile('og_image')) {
            $data['og_image'] = $request->file('og_image')->store('products/og_images', 'public');
        } elseif (isset($data['photo'])) {
            $data['og_image'] = $data['photo'];
        }

        // Create product record in database
        $product = Product::create($data);

        // Process & Save Dynamic FAQs
        $this->syncFaqs($product, $request);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully with usage steps & FAQs!');
    }

    /**
     * 4. Show form to edit an existing product (EDIT)
     */
    public function edit(Product $product): View
    {
        $product->load('faqs');
        return view('admin.pages.products.edit', compact('product'));
    }

    /**
     * 5. Update existing product in database (UPDATE)
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        // Form Validation
        $request->validate([
            'name'           => 'required|string|max:255',
            'price'          => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'discount'       => 'nullable|string|max:50',
            'badge'          => 'nullable|string|max:50',
            'stock'          => 'required|integer|min:0',
            'photo'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'detail'         => 'nullable|string',
            'how_to_use'     => 'nullable|string',
            'meta_title'     => 'nullable|string|max:255',
            'meta_detail'    => 'nullable|string',
            'og_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Process structured How-To-Use Steps if provided
        $steps = $this->parseSteps($request);

        $data = [
            'name'             => $request->name,
            'price'            => $request->price,
            'original_price'   => $request->original_price,
            'discount'         => $request->discount,
            'badge'            => $request->filled('badge') ? $request->badge : ($product->badge ?: 'NATURAL'),
            'stock'            => $request->stock,
            'detail'           => $request->detail,
            'how_to_use'       => $request->how_to_use,
            'how_to_use_steps' => count($steps) > 0 ? $steps : null,
            'meta_title'       => $request->meta_title,
            'meta_detail'      => $request->meta_detail,
        ];

        // 1. If new Photo uploaded, delete old one and store new one
        if ($request->hasFile('photo')) {
            if ($product->photo && Storage::disk('public')->exists($product->photo)) {
                Storage::disk('public')->delete($product->photo);
            }
            $data['photo'] = $request->file('photo')->store('products/photos', 'public');
        }

        // 2. If new OG Image uploaded, delete old one and store new one
        if ($request->hasFile('og_image')) {
            if ($product->og_image && Storage::disk('public')->exists($product->og_image)) {
                Storage::disk('public')->delete($product->og_image);
            }
            $data['og_image'] = $request->file('og_image')->store('products/og_images', 'public');
        }

        // Update product in database
        $product->update($data);

        // Process & Save Dynamic FAQs
        $this->syncFaqs($product, $request);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully with usage steps & FAQs!');
    }

    /**
     * 6. Delete a product from database and remove image files (DELETE)
     */
    public function destroy(Product $product): RedirectResponse
    {
        // Delete image files from storage if present
        if ($product->photo && Storage::disk('public')->exists($product->photo)) {
            Storage::disk('public')->delete($product->photo);
        }

        if ($product->og_image && Storage::disk('public')->exists($product->og_image)) {
            Storage::disk('public')->delete($product->og_image);
        }

        // Delete associated FAQs
        $product->faqs()->delete();

        // Delete from database
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }

    /**
     * Helper: Parse step inputs into structured JSON array
     */
    private function parseSteps(Request $request): array
    {
        $steps = [];
        if ($request->has('step_title') && is_array($request->step_title)) {
            $num = 1;
            foreach ($request->step_title as $idx => $title) {
                if (!empty(trim($title))) {
                    $steps[] = [
                        'step_number' => str_pad($num++, 2, '0', STR_PAD_LEFT),
                        'title'       => trim($title),
                        'description' => trim($request->step_desc[$idx] ?? ''),
                        'timing'      => trim($request->step_timing[$idx] ?? 'Daily Routine'),
                        'icon'        => trim($request->step_icon[$idx] ?? 'bi-capsule'),
                    ];
                }
            }
        }
        return $steps;
    }

    /**
     * Helper: Synchronize dynamic FAQs for product
     */
    private function syncFaqs(Product $product, Request $request): void
    {
        if ($request->has('faq_question') && is_array($request->faq_question)) {
            $product->faqs()->delete();
            $sort = 1;
            foreach ($request->faq_question as $idx => $question) {
                $q = trim($question);
                $a = trim($request->faq_answer[$idx] ?? '');
                if (!empty($q) && !empty($a)) {
                    ProductFaq::create([
                        'product_id' => $product->id,
                        'question'   => $q,
                        'answer'     => $a,
                        'sort_order' => $sort++,
                        'is_active'  => true,
                    ]);
                }
            }
        } elseif ($request->has('faqs_cleared')) {
            $product->faqs()->delete();
        }
    }
}
