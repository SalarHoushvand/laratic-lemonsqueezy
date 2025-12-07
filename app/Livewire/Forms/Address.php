<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Address extends Component
{
    #[Validate('required|string|max:255')]
    public $country = '';

    #[Validate('nullable|string|max:255')]
    public $street = '';

    #[Validate('nullable|string|max:255')]
    public $city = '';

    #[Validate('nullable|string|max:255')]
    public $state = '';

    #[Validate('nullable|string|max:20')]
    public $zip = '';

    #[Validate('nullable|string|max:255')]
    public $timezone = '';

    public function mount()
    {
        $user = auth()->user();

        $this->fill([
            'country' => $user->country,
            'street' => $user->street,
            'city' => $user->city,
            'state' => $user->state,
            'zip' => $user->zip,
            'timezone' => $user->timezone,
        ]);
    }

    public function submit()
    {
        $validated = $this->validate();

        auth()->user()->update($validated);

        Log::info('User updated address', [
            'user_id' => auth()->id(),
        ]);

        $this->dispatch('notify',
            variant: 'success',
            title: __('Address Updated'),
            message: __('Your address has been updated successfully!')
        );

        $this->dispatch('address-updated');
    }

    /**
     * Get list of available timezones.
     *
     * @return array<string, array<string, string>>
     */
    public function getTimezonesProperty(): array
    {
        $timezones = timezone_identifiers_list();
        $grouped = [];

        foreach ($timezones as $timezone) {
            $parts = explode('/', $timezone);
            if (count($parts) > 1) {
                $region = $parts[0];
                $city = implode('/', array_slice($parts, 1));
                $grouped[$region][$city] = $timezone;
            } else {
                $grouped['Other'][$timezone] = $timezone;
            }
        }

        ksort($grouped);
        foreach ($grouped as &$region) {
            ksort($region);
        }

        return $grouped;
    }

    public function render()
    {
        return view('livewire.forms.address');
    }
}
