<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AffiliateController extends Controller
{
    public function create(): View
    {
        return view('affiliates.create-affiliates', ['affiliates' => null]);
    }
    public function store(Request $request)
    {

        // $request->validate([

        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => [
        //         'required',
        //         'string',
        //         'lowercase',
        //         'email',
        //         'max:255',
        //         Rule::unique('users'),
        //     ],
        //     'password' => ['required', 'confirmed', Rules\Password::defaults()],
        // ]);
        try {
            User::create([
                'cpf_cnpj' => Auth::user()->cpf_cnpj,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => Auth::user()->phone,
                'usertype' => '1',
            ]);

            return redirect()->route('dashboard')->with('success', 'Afiliado cadastrado com sucesso');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('fail', "Erro ao cadastrar o Afiliado");
        }
    }
    public function show(User $affiliate)
    {
        $affiliates = User::where('usertype', '1')->orderBy('created_at', 'desc')->paginate(5);

        return view('affiliates.show-affiliates', compact('affiliates'));
    }
    

    public function edit($id)
    {
        $affiliates = User::findOrFail($id);

        return view('affiliates.create-affiliates', compact('affiliates'));
    }

    public function update(Request $request, $id)
    {

        $affiliate = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $affiliate->id,
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
        $affiliate = User::findOrFail($id);
        $affiliate->delete();
        return redirect()->route('affiliate.show')->with('success', 'Afiliado excluído com sucesso.');
    }
}
