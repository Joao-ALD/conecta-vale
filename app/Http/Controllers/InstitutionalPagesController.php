<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstitutionalPagesController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }
}
