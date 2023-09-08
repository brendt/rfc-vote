<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination;

    public string $search = '';

    public ?int $isDeletingId = null;

    public function render(): View
    {
        return view('livewire.user-list', [
            'users' => \App\Models\User::query()
                ->where('name', 'like', '%'.$this->search.'%')
                ->orWhere('email', 'like', '%'.$this->search.'%')
                ->paginate(20),
        ])->layout('layouts.admin');
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function deleteUser(int $id): void
    {
        $user = User::findOrFail($id);
        $user->delete();
        $this->isDeletingId = null;
    }
}
