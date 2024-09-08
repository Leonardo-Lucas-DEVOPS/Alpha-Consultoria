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
        return view('affiliates.create-affiliates', ['affiliates' => null]);
    }
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
    public function show(Affiliate $affiliate)
    {
        $affiliates = Affiliate::orderBy('created_at', 'desc')->paginate(5);
        return view('affiliates.show-affiliates', compact('affiliates'));
    }

    public function edit($id)
    {
        $affiliates = Affiliate::findOrFail($id);
        
        return view('affiliates.create-affiliates', compact('affiliates'));
    }

    public function update(Request $request, $id)
    {
        
        $affiliate = Affiliate::findOrFail($id);
    
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:affiliates,email,' . $affiliate->id,
        ]);
    
        $affiliate->name = $request->input('name');
        $affiliate->email = $request->input('email');
    
        // Se a checkbox "reset_password" estiver marcada
        if ($request->has('reset_password')) {
            // Redefine a senha para um valor padrão ou gera uma nova senha aleatória
            $affiliate->password = Hash::make('12345678'); // Ou use Str::random(8) para uma senha aleatória
        }
    
        $affiliate->save();
    
        return redirect()->route('affiliate.show')->with('success', 'Afiliado atualizado com sucesso.');
    }
    

    public function destroy($id)
    {
        $affiliate = Affiliate::findOrFail($id);
        $affiliate->delete();
        return redirect()->route('affiliate.show')->with('success', 'Afiliado excluído com sucesso.');
   }

}
