<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    /**
     * Show the screen for dashboard.
     *
     * @return \Illuminate\Contracts\View
     */
    public function show()
    {
        return view('pages.dashboard');
    }
}
