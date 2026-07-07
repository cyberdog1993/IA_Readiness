<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;

class Login extends BaseLogin
{
    protected static string $view = 'filament.auth.login';

    public function getHeading(): string
    {
        return 'Acceso interno';
    }

    public function getSubHeading(): ?string
    {
        return 'Diagnóstico, preventa y ejecución en un solo lugar.';
    }
}
