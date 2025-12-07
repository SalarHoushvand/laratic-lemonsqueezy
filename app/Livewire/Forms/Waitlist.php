<?php

namespace App\Livewire\Forms;

use App\Models\Waitlist as WaitlistModel;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Newsletter\Facades\Newsletter as NewsletterMailchimp;

class Waitlist extends Component
{
    #[Validate('required|email|max:255')]
    public $email = '';

    #[Validate('required|boolean')]
    public $data_processing_consent = false;

    // Honeypot
    public $website = '';

    public function submit()
    {
        // Check honeypot
        if ($this->website) {
            return;
        }

        $validated = $this->validate();

        $waitlist = WaitlistModel::create($validated);

        // Process the waitlist submission here
        // NewsletterMailchimp::subscribeOrUpdate($validated['email']);

        // Reset form
        $this->reset(['email', 'data_processing_consent']);

        // Show success message
        $this->dispatch('notify',
            variant: 'success',
            title: __('Waitlist Submitted'),
            message: __('You have been added to the waitlist!')
        );
    }

    public function render()
    {
        return view('livewire.forms.waitlist');
    }
}
