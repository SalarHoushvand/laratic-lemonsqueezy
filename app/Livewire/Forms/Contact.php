<?php

namespace App\Livewire\Forms;

use App\Mail\NewContactRequestMail;
use App\Models\ContactRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Contact extends Component
{
    #[Validate('required|string|max:255')]
    public $name = '';

    #[Validate('required|email|max:255')]
    public $email = '';

    #[Validate('nullable|string|max:14')]
    public $phone = '';

    #[Validate('required|string')]
    public $country = '';

    #[Validate('required|string|max:600')]
    public $message = '';

    #[Validate('required|accepted')]
    public $data_processing_consent = false;

    #[Validate('boolean')]
    public $phone_consent = false;

    #[Validate('boolean')]
    public $marketing_consent = false;

    // Honeypot field
    public $website = '';

    public function submit()
    {
        // Honeypot field
        if ($this->website) {
            return;
        }

        $validated = $this->validate();

        $contactRequest = ContactRequest::create($validated);

        Mail::to(env('CONTACT_EMAIL'))
            ->send(new NewContactRequestMail($validated));

        $this->dispatch('notify',
            variant: 'success',
            title: __('Message Sent'),
            message: __('Your message has been sent successfully!')
        );

        $this->reset();

        $this->addToMailList($contactRequest);
    }

    public function addToMailList(ContactRequest $contactRequest)
    {
        if ($contactRequest->marketing_consent) {
            // Add newsletter subscription logic here
            // Newsletter::subscribe($contact->email);
            Log::info('User subscribed to newsletter from contact form', [
                'email' => $contactRequest->email,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.forms.contact');
    }
}
