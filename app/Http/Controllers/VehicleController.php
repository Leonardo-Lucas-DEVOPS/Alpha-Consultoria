<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    public function create(){
        return view('vehicle.create-vehicle');
    }
}
