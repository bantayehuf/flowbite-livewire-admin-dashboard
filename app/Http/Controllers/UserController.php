<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    /**
     * Show the screen for the list of users.
     *
     * @return \Illuminate\Contracts\View
     */
    public function show()
    {
        return view('pages.users');
    }


    /**
     * Show the screen for self profile.
     *
     * @return \Illuminate\Contracts\View
     */
    public function profile()
    {
        return view('pages.profile');
    }
}
