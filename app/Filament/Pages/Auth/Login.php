<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\TextInput;
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

    protected function getEmailFormComponent(): TextInput
    {
        return parent::getEmailFormComponent()
            ->autocomplete('off')
            ->placeholder('admin@consultores-it.pe')
            ->extraInputAttributes([
                'autocapitalize' => 'none',
                'spellcheck' => 'false',
                'inputmode' => 'email',
            ]);
    }

    protected function getPasswordFormComponent(): TextInput
    {
        return parent::getPasswordFormComponent()
            ->autocomplete('new-password');
    }
}
