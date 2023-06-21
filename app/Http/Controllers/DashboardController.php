<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // dd(Auth::check());
        // dd(Auth::user());
        // $user = $request->user();
        // dd($user);
        return view('dashboard');
    }
    // protected function authenticated( $user)
    // {

    //     if($user->user_group == '0') {
    //         return redirect('/dashboard');
    //     }

    //     return redirect('my-account');
    // }
}
