<?php

namespace App\Http\Controllers\Headmaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HeadmasterController extends Controller
{
    public function dashboard() {
        return view('headmaster.dashboard');
    }
}
