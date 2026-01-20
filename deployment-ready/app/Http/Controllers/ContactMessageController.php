<?php
namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\ContactInfo;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index()
    {
        // Ensure locale is set from URL
        $locale = request()->segment(1);
        if (in_array($locale, ['en', 'ar'])) {
            app()->setLocale($locale);
        }
        
        $contactInfos = ContactInfo::all();
        return view('contact.index', compact('contactInfos'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:30',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:10|max:1000',
        ]);
        ContactMessage::create($data);
        return response()->json(['success' => true, 'message' => 'Message sent successfully.']);
    }
} 