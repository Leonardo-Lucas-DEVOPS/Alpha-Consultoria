<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        // Autentica o usuário
        $request->authenticate();

        // Regenera a sessão para evitar ataques de session fixation
        $request->session()->regenerate();

        // Chama a função first_access após autenticação
        return $this->first_access();
    }

    /**
     * Verifica se o usuário precisa alterar a senha após verificação recente do e-mail.
     */
    public function first_access(): RedirectResponse
    {
        // Verifica se o usuário está autenticado e se o e-mail foi verificado
        if (Auth::check() && Auth::user()->email_verified_at) {
            // Verifica se a verificação de e-mail foi feita há menos de 5 minutos
            if (Auth::user()->email_verified_at->diffInMinutes(now()) < 5) {
                // Redireciona para a dashboard com uma mensagem de alerta
                return redirect()->intended(route('dashboard', absolute: false))
                                 ->with('alert', 'Por favor, altere sua senha em seu perfil.');
            }
        }

        // Redireciona para a dashboard sem alerta caso a verificação seja maior que 5 minutos
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
      
    
        // Realiza o logout do usuário no guard 'web'
        Auth::guard('web')->logout();
    
        // Invalida a sessão atual
        $request->session()->invalidate();
    
        // Regenera o token CSRF para a nova sessão
        $request->session()->regenerateToken();
    
        // Redireciona para a página inicial
        return redirect('/');
    }
    
}
