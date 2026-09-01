<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Store a new contact message inquiry.
     */
    public function submit(Request $request): JsonResponse|RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255'],
            'contactno' => ['required', 'string', 'max:30'],
            'subject'   => ['required', 'string', 'max:255'],
            'messages'  => ['required', 'string', 'max:5000'],
        ], [
            'name.required'      => 'Please enter your full name.',
            'email.required'     => 'An email address is required.',
            'email.email'        => 'Please provide a valid email address.',
            'contactno.required' => 'Please enter your contact phone number.',
            'subject.required'   => 'Please provide a subject for your inquiry.',
            'messages.required'  => 'Please enter your message or question.',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                    'errors'  => $validator->errors(),
                ], 422);
            }

            return back()->withErrors($validator)->withInput()->with('contact_error', $validator->errors()->first());
        }

        $contact = Contact::create([
            'name'      => trim($request->name),
            'email'     => trim(strtolower($request->email)),
            'contactno' => trim($request->contactno),
            'subject'   => trim($request->subject),
            'messages'  => trim($request->messages),
            'status'    => 'Unread',
        ]);

        $successMsg = 'Thank you, ' . $contact->name . '! Your message has been received. Our wellness team will get in touch with you shortly.';

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $successMsg,
                'contact' => [
                    'id'      => $contact->id,
                    'name'    => $contact->name,
                    'email'   => $contact->email,
                    'subject' => $contact->subject,
                ],
            ], 201);
        }

        return back()->with('contact_success', $successMsg);
    }
}
