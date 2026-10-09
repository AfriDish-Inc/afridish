<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class VendorsController extends Controller
{
    public function index()
    {
        $vendors = User::whereIn('user_type', ['V', 'CH', 'R'])->latest()->paginate(10);
        return view('admin.vendors.index', compact('vendors'));
    }
}
