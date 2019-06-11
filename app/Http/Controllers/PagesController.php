<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class PagesController extends Controller
{
    public function home()
    {
        $carousel = Storage::files("public/carousel");

        return view('index', ['carousel'=>$carousel]);
    }

    public function new_residents()
    {
        return view('pages.new_residents');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function terms()
    {
        return view('pages.terms');
    }
}
