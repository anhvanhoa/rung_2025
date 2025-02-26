<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class C_Database extends Controller
{
    public function processing()
    {
        return view("pages.db-processing");
    }
}
