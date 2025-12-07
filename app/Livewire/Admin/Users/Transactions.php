<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;

class Transactions extends Component
{
    public $user;

    public function render()
    {
        return view('livewire.admin.users.transactions');
    }
}
