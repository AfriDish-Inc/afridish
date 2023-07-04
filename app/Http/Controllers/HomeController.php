<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Product;
use Carbon\Carbon;
use App\Traits\GlobalTrait;

class HomeController extends Controller
{
    use GlobalTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('user.home');
    }



    public function adminHome(Request $request){
        if (auth()->user()->user_type == "V" || auth()->user()->user_type == "CH" || auth()->user()->user_type == "R") {
             $totalProducts = Product::where('provider_id',auth()->user()->id)->count();
             $validity = $this->remainingDate();
         }else{
             $totalProducts = Product::count();
             $validity = "";
         }
        
        return view('home',compact('totalProducts','validity'));
    }
}
