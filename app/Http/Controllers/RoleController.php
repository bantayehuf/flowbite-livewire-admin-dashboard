<?php

namespace App\Http\Controllers;

class RoleController extends Controller
{
    /**
     * Show the roles screen.
     *
     * @return \Illuminate\Contracts\View
     */
    public function show()
    {
        return view('pages.roles');
    }
}
