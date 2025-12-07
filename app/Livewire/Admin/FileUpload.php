<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin')]
class FileUpload extends Component
{
    /**
     * The uploaded file URL from Cloudinary.
     */
    public string $fileUrl = '';

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.admin.file-upload');
    }
}
