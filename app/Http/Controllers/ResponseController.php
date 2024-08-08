<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Freelancer;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class ResponseController extends Controller
{
    public function update(){
        
        $page = 'return';
        $vehicles = Vehicle::orderBy('created_at','desc')->paginate(10);
        $employees = Employee::orderBy('created_at','desc')->paginate(10);
        $freelancers = Freelancer::orderBy('created_at','desc')->paginate(10);
         
        return view('response.show-response', compact( 'page','vehicles','freelancers','employees'));
    }

    public function accept($id){return redirect()->route('dashboard');
    }
    public function recuse($id){return redirect()->route('dashboard');
    }
    
}
