<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController
{
    //
    public function __invoke(){
        return view('home');
    }
}
