<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Verifica se o usuário está autenticado no guard 'affiliate'
        if (Auth::guard('affiliate')->check()) {
            Auth::guard('affiliate')->logout();
        }
    
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
