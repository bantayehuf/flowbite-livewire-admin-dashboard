<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Show the screen for the list of users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function show(Request $request)
    {
        return view('pages.users');
    }


    /**
     * Show the screen for self profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function profile(Request $request)
    {
        return view('pages.profile', [
            'request' => $request,
            'user' => $request->user(),
        ]);
    }
}
