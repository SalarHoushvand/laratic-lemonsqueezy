<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class DashboardTest extends Component
{
    public $categories = [];
    public  $options = [
        [
            'value' => 1,
            'label' => 'Category 1',
        ],
        [
            'value' => 2,
            'label' => 'Category 2',
        ],
    ];

    public function mount()
    {
       
    }
}
