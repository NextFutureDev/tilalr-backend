<?php

namespace App\Http\Controllers\Admin;

use App\Models\CustomPaymentOffer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class CustomPaymentOfferController extends Controller
{
    /**
     * Show list of custom payment offers
     */
    public function index()
    {
        $offers = CustomPaymentOffer::where('created_by', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.custom-payment-offers.index', compact('offers'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.custom-payment-offers.create');
    }

    /**
     * Store new custom payment offer
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:1000',
        ], [
            'customer_name.required' => 'اسم العميل مطلوب',
            'customer_email.required' => 'البريد الإلكتروني مطلوب',
            'customer_email.email' => 'البريد الإلكتروني غير صحيح',
            'customer_phone.required' => 'رقم الهاتف مطلوب',
            'amount.required' => 'المبلغ مطلوب',
            'amount.numeric' => 'المبلغ يجب أن يكون رقماً',
            'amount.min' => 'المبلغ الأدنى 0.01',
            'description.required' => 'الوصف مطلوب',
        ]);

        // Generate unique link
        $uniqueLink = Str::random(32);
        while (CustomPaymentOffer::where('unique_link', $uniqueLink)->exists()) {
            $uniqueLink = Str::random(32);
        }

        // Create offer
        $offer = CustomPaymentOffer::create([
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'amount' => $validated['amount'],
            'description' => $validated['description'],
            'unique_link' => $uniqueLink,
            'payment_status' => 'pending',
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('admin.custom-payment-offers.show', $offer->id)
            ->with('success', 'تم إنشاء عرض الدفع بنجاح!');
    }

    /**
     * Show offer with payment link
     */
    public function show(CustomPaymentOffer $customPaymentOffer)
    {
        // Ensure user owns this offer
        if ($customPaymentOffer->created_by !== auth()->id()) {
            abort(403, 'غير مصرح');
        }

        $paymentLink = url('/pay-custom-offer/' . $customPaymentOffer->unique_link);

        return view('admin.custom-payment-offers.show', compact('customPaymentOffer', 'paymentLink'));
    }

    /**
     * Show edit form
     */
    public function edit(CustomPaymentOffer $customPaymentOffer)
    {
        // Ensure user owns this offer
        if ($customPaymentOffer->created_by !== auth()->id()) {
            abort(403, 'غير مصرح');
        }

        return view('admin.custom-payment-offers.edit', compact('customPaymentOffer'));
    }

    /**
     * Update custom payment offer
     */
    public function update(Request $request, CustomPaymentOffer $customPaymentOffer)
    {
        // Ensure user owns this offer
        if ($customPaymentOffer->created_by !== auth()->id()) {
            abort(403, 'غير مصرح');
        }

        // Only allow editing if payment is still pending
        if ($customPaymentOffer->payment_status !== 'pending') {
            return redirect()
                ->back()
                ->with('error', 'لا يمكن تعديل عرض دفع تم دفعه بالفعل');
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:1000',
        ]);

        $customPaymentOffer->update($validated);

        return redirect()
            ->route('admin.custom-payment-offers.show', $customPaymentOffer->id)
            ->with('success', 'تم تحديث عرض الدفع بنجاح!');
    }

    /**
     * Delete custom payment offer
     */
    public function destroy(CustomPaymentOffer $customPaymentOffer)
    {
        // Ensure user owns this offer
        if ($customPaymentOffer->created_by !== auth()->id()) {
            abort(403, 'غير مصرح');
        }

        $customPaymentOffer->delete();

        return redirect()
            ->route('admin.custom-payment-offers.index')
            ->with('success', 'تم حذف عرض الدفع بنجاح!');
    }
}
