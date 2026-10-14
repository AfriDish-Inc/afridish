<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiriesController extends Controller
{
    public function index()
    {
        $inquiries = Inquiry::with(['user', 'product'])
            ->where('vendor_id', auth()->user()->id)
            ->latest()
            ->paginate(10);

        return view('admin.inquiries.index', compact('inquiries'));
    }

    public function updateStatus(Request $request)
    {
        $updated = Inquiry::where('id', $request->inquiry_id)
            ->where('vendor_id', auth()->user()->id)
            ->update(['status' => $request->status]);

        if ($updated === 0) {
            abort(403);
        }

        return response()->json(['status' => true, 'message' => 'Inquiry updated.'], 200);
    }
}
