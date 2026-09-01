<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the Admin Dashboard Overview.
     */
    public function index(): View
    {
        $productsCount = Product::count();
        $reviewsCount = Review::count();
        $contactsCount = Contact::count();
        $unreadContactsCount = Contact::where('status', 'Unread')->count();

        $ordersCount = Order::count();
        $totalRevenue = (float) Order::where('status', '!=', 'Cancelled')->sum('total_amount');
        $recentOrders = Order::with(['user', 'items'])->latest()->take(5)->get();

        $recentProducts = Product::latest()->take(5)->get();
        $recentContacts = Contact::latest()->take(5)->get();

        return view('admin.pages.dashboard', compact(
            'productsCount',
            'reviewsCount',
            'contactsCount',
            'unreadContactsCount',
            'ordersCount',
            'totalRevenue',
            'recentOrders',
            'recentProducts',
            'recentContacts'
        ));
    }
}
