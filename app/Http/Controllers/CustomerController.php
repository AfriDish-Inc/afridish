<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class CustomerController extends Controller
{
    public function index()
    {
      $users = User::where('user_type' , 'C')->paginate(5);
      return view('admin.users.index',compact('users'));
    }
}
