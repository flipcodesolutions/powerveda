<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Display a listing of contact messages/inquiries.
     */
    public function index(Request $request): View
    {
        $query = Contact::latest();

        // Search filter
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('contactno', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('messages', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status') && in_array($request->status, ['Unread', 'Read', 'Replied'])) {
            $query->where('status', $request->status);
        }

        $contacts = $query->paginate(15)->withQueryString();

        $stats = [
            'total'   => Contact::count(),
            'unread'  => Contact::where('status', 'Unread')->count(),
            'read'    => Contact::where('status', 'Read')->count(),
            'replied' => Contact::where('status', 'Replied')->count(),
        ];

        return view('admin.pages.contacts.index', compact('contacts', 'stats'));
    }

    /**
     * Display specific inquiry and auto-mark as Read.
     */
    public function show(int $id): JsonResponse|View
    {
        $contact = Contact::findOrFail($id);
        $contact->markAsRead();

        if (request()->expectsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'contact' => $contact,
            ]);
        }

        return view('admin.pages.contacts.show', compact('contact'));
    }

    /**
     * Update the status of an inquiry.
     */
    public function updateStatus(Request $request, int $id): JsonResponse|RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'string', 'in:Unread,Read,Replied'],
        ]);

        $contact = Contact::findOrFail($id);
        $contact->update(['status' => $request->status]);

        $msg = 'Inquiry status updated to ' . $contact->status . '.';

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $msg,
                'status'  => $contact->status,
            ]);
        }

        return back()->with('success', $msg);
    }

    /**
     * Remove the specified contact inquiry.
     */
    public function destroy(int $id): JsonResponse|RedirectResponse
    {
        $contact = Contact::findOrFail($id);
        $name = $contact->name;
        $contact->delete();

        $msg = "Inquiry from {$name} has been deleted.";

        if (request()->expectsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $msg,
            ]);
        }

        return redirect()->route('admin.contacts.index')->with('success', $msg);
    }
}
