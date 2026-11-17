<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use App\Models\Product;
use App\Models\ProductFaq;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display the Yuvar Dhan Storefront Home page with database products, reviews, usage guides and FAQs.
     */
    public function home(): View
    {
        $products = Product::with(['activeFaqs'])->latest()->get();
        $latestProduct = $products->first();
        $reviews = Review::with('product')->where('status', 'Approved')->latest()->get();
        $faqs = ProductFaq::where('is_active', true)->with('product')->orderBy('sort_order', 'asc')->orderBy('id', 'asc')->get();

        return view('visitor.pages.home', compact('products', 'latestProduct', 'reviews', 'faqs'));
    }

    /**
     * Display the Dedicated Product Detail page using SEO-friendly Slug.
     */
    public function productDetail(string|Product $product): View|\Illuminate\Http\RedirectResponse
    {
        // If route-model bound as Product instance
        if ($product instanceof Product) {
            $productModel = $product;
        } else {
            // Find by slug or fallback to numeric ID
            $productModel = Product::where('slug', $product)->first();
            if (!$productModel && is_numeric($product)) {
                $productModel = Product::find((int) $product);
                if ($productModel && $productModel->slug) {
                    return redirect()->route('product.detail', $productModel->slug, 301);
                }
            }
            if (!$productModel) {
                abort(404, 'Product formulation not found.');
            }
        }

        $productModel->load([
            'activeFaqs',
            'reviews' => function ($q) {
                $q->where('status', 'Approved')->latest();
            }
        ]);

        $relatedProducts = Product::where('id', '!=', $productModel->id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('visitor.pages.product-detail', ['product' => $productModel, 'relatedProducts' => $relatedProducts]);
    }

    /**
     * Display the About Us & Healthcare Association page.
     */
    public function about(): View
    {
        return view('visitor.pages.about');
    }

    /**
     * Display the Privacy Policy page dynamically from CMS.
     */
    public function privacy(): View
    {
        $page = CmsPage::where('slug', 'privacy-policy')->firstOrFail();
        return view('visitor.pages.policy', compact('page'));
    }

    /**
     * Display the Terms & Conditions page dynamically from CMS.
     */
    public function terms(): View
    {
        $page = CmsPage::where('slug', 'terms-and-conditions')->firstOrFail();
        return view('visitor.pages.policy', compact('page'));
    }

    /**
     * Display the Refund Policy page dynamically from CMS.
     */
    public function refund(): View
    {
        $page = CmsPage::where('slug', 'refund-policy')->firstOrFail();
        return view('visitor.pages.policy', compact('page'));
    }

    /**
     * Display the Return Policy page dynamically from CMS.
     */
    public function return(): View
    {
        $page = CmsPage::where('slug', 'return-policy')->firstOrFail();
        return view('visitor.pages.policy', compact('page'));
    }

    /**
     * Display the Shipping Policy page dynamically from CMS.
     */
    public function shipping(): View
    {
        $page = CmsPage::where('slug', 'shipping-policy')->firstOrFail();
        return view('visitor.pages.policy', compact('page'));
    }

    /**
     * Display any Policy page dynamically by slug.
     */
    public function showPolicy(string $slug): View
    {
        $page = CmsPage::where('slug', $slug)->firstOrFail();
        return view('visitor.pages.policy', compact('page'));
    }

    /**
     * Display the My Account & Orders Dashboard page (protected - logged-in users only).
     */
    public function account(): View|\Illuminate\Http\RedirectResponse
    {
        if (!auth()->check()) {
            return redirect()->route('home')->with('openAuthModal', true)->with('error', 'Please log in to access your account and orders.');
        }

        $user = auth()->user();
        $addresses = $user
            ->addresses()
            ->orderBy('is_default', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $orders = $user
            ->orders()
            ->with('items')
            ->latest()
            ->get();

        return view('visitor.pages.account', compact('user', 'addresses', 'orders'));
    }
}
