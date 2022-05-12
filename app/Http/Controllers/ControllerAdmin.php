<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerAdmin extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('admin');
    }
}
