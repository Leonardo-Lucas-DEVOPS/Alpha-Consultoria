<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class FinanceController extends Controller
{
    public function show() {
        return view('finance.show-finance', ['finances' => null]);
    }
}
