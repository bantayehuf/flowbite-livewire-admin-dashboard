<?php

namespace App\Http\Controllers;

class DepartmentController extends Controller
{
    /**
     * Show the department screen.
     *
     * @return \Illuminate\Contracts\View
     */
    public function show()
    {
        return view('pages.departments');
    }
}
