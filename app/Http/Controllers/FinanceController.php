<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class FinanceController extends Controller
{
    public function show() {
        $companies = User::join('employees', 'users.id', '=', 'employees.user_id')
                         ->join('freelancers', 'users.id', '=', 'freelancers.user_id')
                         ->join('vehicles', 'users.id', '=', 'vehicles.user_id')
                         ->select('users.name AS Usuario',
                                   User::raw('COUNT(DISTINCT employees.id) AS Funcionarios'),
                                   User::raw('COUNT(DISTINCT freelancers.id) AS Prestadores'),
                                   User::raw('COUNT(DISTINCT vehicles.id) AS Veiculos')
                                 )
                         ->where('users.usertype', '2')
                         ->groupBy('users.name')
                         ->orderBy('users.created_at', 'desc')
                         ->paginate(5);
                         
        return view('finance.show-finance', compact('companies'));
    }
}
