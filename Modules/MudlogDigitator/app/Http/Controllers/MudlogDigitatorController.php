<?php

namespace Modules\MudlogDigitator\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MudlogDigitatorController extends Controller
{
    public function index()
    {
        return view('mudlogdigitator::index');
    }
}
