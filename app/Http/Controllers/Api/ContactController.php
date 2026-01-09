<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Store a new contact form submission.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $contact = Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject ?? 'General Inquiry',
                'message' => $request->message,
                'status' => 'new',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Your message has been sent successfully!',
                'contact' => $contact
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send message. Please try again later.',
            ], 500);
        }
    }

    /**
     * Get all contact submissions (for admin).
     */
    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(20);
        
        return response()->json([
            'success' => true,
            'contacts' => $contacts
        ]);
    }

    /**
     * Get a single contact submission.
     */
    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        
        // Mark as read
        if ($contact->status === 'new') {
            $contact->update(['status' => 'read']);
        }
        
        return response()->json([
            'success' => true,
            'contact' => $contact
        ]);
    }

    /**
     * Update contact status.
     */
    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);
        
        $contact->update([
            'status' => $request->status ?? $contact->status,
            'notes' => $request->notes ?? $contact->notes,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Contact updated successfully',
            'contact' => $contact
        ]);
    }

    /**
     * Delete a contact submission.
     */
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Contact deleted successfully'
        ]);
    }
}
