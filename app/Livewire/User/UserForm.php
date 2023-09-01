<?php

namespace App\Livewire\User;

use App\Enums\UserAccountStatus;
use Livewire\Form;
use App\Utils\Strg;
use App\Models\User;
use App\Utils\Toast;
use App\Utils\Validator;
use Illuminate\Support\Str;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserForm extends Form
{
    #[Locked]
    public ?User $user;

    #[Locked]
    public $createdUser = [
        'full_name' => '',
        'email' => '',
        'department' => '',
        'password' => '',
    ];

    #[Rule('required|min:2')]
    public $name = '';

    #[Rule('required|email')]
    public $email = '';

    #[Rule('required|int')]
    public $department = '';


    public function store()
    {
        $validated = $this->validate();
        $email = Strg::sanitize($validated['email']);

        Validator::unique('form.email', 'users', 'email', $email);

        DB::transaction(function () use ($validated, $email) {
            $name = Strg::upperWordsFirst($validated['name']);
            $password = Str::password(length: 8, symbols: false);

            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'department' => $validated['department'],
                'created_by' => Auth::id(),
            ]);

            $dep = DB::table('departments as d')
                ->select('d.name')
                ->where('d.id', '=', $validated['department'])
                ->first();

            $this->createdUser = [
                'full_name' => $name,
                'email' => $validated['email'],
                'department' => $dep->name,
                'password' => $password,
            ];
        });


        $this->reset('user', 'name', 'email', 'department');

        $this->component->dispatch('close-user-management-modal');

        $this->component->dispatch('show-created-user-modal', title: 'Created User Information');
    }

    public function resetPassword($id)
    {
        DB::transaction(function () use ($id) {
            $user = User::findOrFail($id);

            $password = Str::password(length: 8, symbols: false);

            $user->password = Hash::make($password);

            $user->save();

            $dep = DB::table('departments as d')
                ->select('d.name')
                ->where('d.id', '=', $user->department)
                ->first();

            $this->createdUser = [
                'full_name' => $user->name,
                'email' => $user->email,
                'department' => $dep->name,
                'password' => $password,
            ];
        });

        $this->component->dispatch('close-action-dialog-modal');

        $this->component->dispatch('show-created-user-modal', title: 'New Password');
    }

    public function changeUserActiveStatus($status)
    {
        DB::transaction(function () use ($status) {
            $id = $status['id'];
            $to = $status['to'];

            if (($to === 0 || $to  === 1)) {

                $change_to = $to === 1 ? UserAccountStatus::Active->value : UserAccountStatus::Blocked->value;

                $user = User::findOrFail($id);

                if($user->account_status !== $change_to){

                    $user->account_status = $change_to;

                    $user->save();

                    // On blocking the user, remove the user session,
                    // To logout if the account has the active session.
                    if ($to  === 0) {
                        // Delete the session
                        DB::table('sessions')
                            ->where('user_id', $user->id)
                            ->delete();
                    }

                }

                Toast::success($this->component, 'User status has been changed successfully!');
            } else {
                Toast::error($this->component, 'The server could not understand the request!');
            }
        });

        $this->component->dispatch('close-user-active-status-dialog-modal');
    }
}
