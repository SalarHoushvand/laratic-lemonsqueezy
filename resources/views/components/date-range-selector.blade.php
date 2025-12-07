@props(['selected' => 'last_30_days'])

@php
    $ranges = [
        'today' => __('Today'),
        'yesterday' => __('Yesterday'),
        'last_7_days' => __('Last 7 Days'),
        'last_10_days' => __('Last 10 Days'),
        'last_30_days' => __('Last 30 Days'),
        'last_3_months' => __('Last 3 Months'),
        'last_6_months' => __('Last 6 Months'),
        'ytd' => __('Year to Date'),
    ];
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center gap-3']) }}>
    <x-input-label for="date-range-selector" class="sr-only" :value="__('Date Range')" />
    <x-select width="w-full" icon="calendar" :chevron="false" id="date-range-selector" name="range" class="date-range-selector">
        @foreach ($ranges as $key => $label)
            <option value="{{ $key }}" @selected($selected === $key)>
                {{ $label }}
            </option>
        @endforeach
    </x-select>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selector = document.getElementById('date-range-selector');
        
        // Handle selection changes
        selector.addEventListener('change', function() {
            const selectedRange = this.value;
            
            // Save to cookie (365 days expiry)
            document.cookie = `admin_date_range=${selectedRange}; path=/; max-age=${365 * 24 * 60 * 60}; SameSite=Lax`;
            
            // Also save to localStorage for backward compatibility
            localStorage.setItem('admin_date_range', selectedRange);
            
            // Update URL and reload
            const url = new URL(window.location.href);
            url.searchParams.set('range', selectedRange);
            window.location.href = url.toString();
        });
    });
</script>

