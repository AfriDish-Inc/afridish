<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Product;
use App\Notifications\NewInquiry;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InquiryController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required|exists:users,id',
            'product_id' => 'nullable|exists:products,id',
            'phone' => 'required',
            'message' => 'required',
            'requested_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()], 200);
        }

        $inquiry = Inquiry::create([
            'user_id' => Auth::id(),
            'vendor_id' => $request->vendor_id,
            'product_id' => $request->product_id,
            'phone' => $request->phone,
            'message' => $request->message,
            'requested_date' => $request->requested_date,
        ]);

        $inquiry->vendor->notify(new NewInquiry($inquiry));

        return response()->json(['status' => true, 'message' => 'Request sent! The vendor will reach out to you directly.'], 200);
    }
}
