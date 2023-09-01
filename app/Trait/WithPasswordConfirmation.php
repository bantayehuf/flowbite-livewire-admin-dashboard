<?php

namespace App\Trait;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

trait WithPasswordConfirmation
{
    public $password = '';

    private function confirmPassoword()
    {
        if (!Hash::check($this->password, Auth::user()->password)) {
            $this->resetPasswordConfirm();

            throw ValidationException::withMessages([
                'password' => [__('This password does not match our records.')],
            ]);
        }
    }

    private function resetPasswordConfirm()
    {
        $this->reset('password');
    }
}
