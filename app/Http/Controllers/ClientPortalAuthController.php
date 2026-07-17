<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ClientPortalAuthController extends Controller
{
    public function create(): View
    {
        return view('portal.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $email = mb_strtolower(trim((string) $credentials['email']));

        $user = User::where('email', $email)
            ->where('role', 'client')
            ->with('client')
            ->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'email' => 'Las credenciales del cliente no coinciden con nuestros registros.',
            ])->onlyInput('email');
        }

        if (! $user->client) {
            return back()->withErrors([
                'email' => 'Esta cuenta no está vinculada a un cliente activo.',
            ])->onlyInput('email');
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();
        $request->session()->put([
            'consulting_intake_client_id' => $user->client_id,
            'consulting_intake_process_id' => null,
        ]);

        return redirect()->route('portal.index');
    }
}
