<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use App\Models\User;
use App\Models\pricing_plan;




class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    

    // Use dependency injection to bring in the PaymentEncode class
    public function __construct()
    {
        
    }


    
    public function login(Request $request)
    {
        $data['page'] = 'Login';
        return view('admin/login')->with($data);
    }

    public function loginSubmit(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|exists:users,email',
        ]);
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $user = Auth::user();
            $request->session()->put('user', $user);
            // Authentication passed...
            return redirect()->intended('/admin/dashboard');
        }

        $request->session()->flash('error', 'The provided credentials do not match our records.');
        return redirect('admin/login');
    }

    public function logout(Request $request)
    {

        $request->session()->forget('user');

        return redirect('admin');
    }

    public function dashboard(Request $request)
    {
        $data['page'] = 'Dashboard';
        return view('admin/dashboard')->with($data);
    }

    public function subscription(Request $request)
    {
        $data['page'] = 'Subscription';
        $data['plans'] = pricing_plan::orderBy('created_at', 'desc')->get();
        return view('admin/subscriptions')->with($data);
    }

    
}
