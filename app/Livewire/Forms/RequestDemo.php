<?php

namespace App\Livewire\Forms;

use App\Mail\DemoRequestMail;
use App\Models\DemoRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Validate;
use Livewire\Component;

class RequestDemo extends Component
{
    #[Validate('required|string|max:255')]
    public $name = '';

    #[Validate('required|email|max:255')]
    public $email = '';

    #[Validate('required|string')]
    public $company_size = '';

    #[Validate('required|string')]
    public $country = '';

    #[Validate('nullable|string|max:300')]
    public $message = '';

    #[Validate('required|accepted')]
    public $data_processing_consent = false;

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

        $demoRequest = DemoRequest::create($validated);

        Mail::to(env('CONTACT_EMAIL'))
            ->send(new DemoRequestMail($validated));

        $this->dispatch('notify',
            variant: 'success',
            title: __('Demo Request Submitted'),
            message: __('Your demo request has been submitted successfully!')
        );

        $this->reset();

        $this->addToMailList($demoRequest);
    }

    public function addToMailList(DemoRequest $demoRequest)
    {
        if ($demoRequest->marketing_consent) {
            // Add newsletter subscription logic here
            // Newsletter::subscribe($demoRequest->email);
            Log::info('User subscribed to newsletter', [
                'email' => $demoRequest->email,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.forms.request-demo');
    }
}
