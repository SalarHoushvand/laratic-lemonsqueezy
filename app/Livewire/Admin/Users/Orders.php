<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;

class Orders extends Component
{
    public $user;

    public function render()
    {
        return view('livewire.admin.users.orders');
    }
}
