<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class UserManagement extends Component
{
    public function updateRole($userId, $newRole)
    {
        // Security: Only Management can do this
        if (!auth()->user()->isManagement()) {
            abort(403);
        }

        $user = User::find($userId);
        $user->update(['role' => $newRole]);
        session()->flash('message', "User role updated to $newRole.");
    }

    public function mount()
    {
        // SECURITY: Kick out anyone who is NOT Management
        if (!auth()->user()->isManagement()) {
            abort(403, 'UNAUTHORIZED: Only Management can access this page.');
        }
    }

    public function render()
    {
        return view('livewire.user-management', [
            'users' => User::all()
        ])->layout('layouts.admin-layout');
    }
}