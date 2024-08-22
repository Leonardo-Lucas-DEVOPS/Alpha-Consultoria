<?php

namespace App\Http\Controllers;

use App\Models\Affiliate;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

use Illuminate\Validation\Rules;
class AffiliateController extends Controller
{
    

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
        return view('affiliates.create-affiliates');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate([
            
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',    
                'max:255',
                Rule::unique('affiliates'),
                Rule::unique('users'),
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
try {
            $affiliate = Affiliate::create([
                'id_affiliate' => Auth::user()->id,
                'name' => $request->name,
                'email' => $request->email,
                'usertype' =>'2',
                'password' => Hash::make($request->password),
            ]);

            return redirect()->route('dashboard')->with('success', 'Afiliado cadastrado com sucesso');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('fail', 'Erro ao cadastrar o Afiliado');
        }
    }
}
