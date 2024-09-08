<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admins.create-admins', ['admins' => null]);
    }

    /**
     * Store a newly created resource in storage.
     */
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

            return redirect()->route('dashboard')->with('success', 'Admin cadastrado com sucesso');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('fail', "Erro ao cadastrar o Admin");
        }
    }

    public function show(User $admin)
    {
        $admins = User::where('usertype', '2')->orderBy('created_at', 'desc')->paginate(5);
        return view('admins.show-admins', compact('admins'));
    }

    public function edit($id)
    {
        $admins = User::findOrFail($id);
        return view('admins.create-admins', compact('admins'));
    }

    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user,email,' . $admin->id,
        ]);

        $admin->name = $request->input('name');
        $admin->email = $request->input('email');

        // Se a checkbox "reset_password" estiver marcada
        if ($request->has('reset_password')) {
            // Redefine a senha para um valor padrão ou gera uma nova senha aleatória
            $admin->password = Hash::make('12345678'); // Ou use Str::random(8) para uma senha aleatória
        }

        $admin->save();

        return redirect()->route('admin.show')->with('success', 'Admin atualizado com sucesso.');
    }


    public function destroy($id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();
        return redirect()->route('admin.show')->with('success', 'Admin excluído com sucesso.');
    }
}
