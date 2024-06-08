<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KaprodiController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:kaprodi');
    }
}
