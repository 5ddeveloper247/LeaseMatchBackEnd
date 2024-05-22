<?php

namespace App\Http\Controllers\BackEnd\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboarController extends Controller
{
    //

    public function Dashboard(Request $request)
    {
        return view('Backend.dashboard.dashboard');
    }
}
