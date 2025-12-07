<?php

namespace App\Livewire\Forms;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Newsletter\Facades\Newsletter as NewsletterMailchimp;

class Newsletter extends Component
{
    #[Validate('required|email|max:255')]
    public string $email = '';

    #[Validate('required|accepted')]
    public bool $data_processing_consent = false;

    /**
     * Honeypot field to prevent spam submissions.
     */
    public string $website = '';

    /**
     * Handle newsletter subscription form submission.
     */
    public function submit(): void
    {
        if ($this->website) {
            return;
        }

        $validated = $this->validate();

        NewsletterMailchimp::subscribeOrUpdate($validated['email']);

        $this->dispatch(
            'notify',
            variant: 'success',
            title: __('Subscription Confirmed'),
            message: __('Thank you for subscribing to our newsletter!')
        );

        $this->reset();
    }

    /**
     * Render the newsletter subscription form component.
     */
    public function render(): View
    {
        return view('livewire.forms.newsletter');
    }
}
