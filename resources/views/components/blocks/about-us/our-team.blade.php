@php
    $teamMembers = [
        [
            'name' => __('David Kim'),
            'role' => __('CTO'),
            'image' => asset('images/avatars/avatar-5.webp'),
        ],
        [
            'name' => __('Tim Harrigan'),
            'role' => __('CEO'),
            'image' => asset('images/avatars/avatar-2.webp'),
        ],
        [
            'name' => __('Emily Davis'),
            'role' => __('VP of Sales'),
            'image' => asset('images/avatars/avatar-8.webp'),
        ],
        [
            'name' => __('Olivia Martinez'),
            'role' => __('Lead Designer'),
            'image' => asset('images/avatars/avatar-6.webp'),
        ],
        [
            'name' => __('James Lee'),
            'role' => __('Senior Developer'),
            'image' => asset('images/avatars/avatar-10.webp'),
        ],
        [
            'name' => __('Sarah Johnson'),
            'role' => __('UX Designer'),
            'image' => asset('images/avatars/avatar-11.webp'),
        ],
    ];
@endphp

<div {{ $attributes }}>
    <x-typography.guest-page-header size="h2" class="mb-4 md:mb-12" title="{{ __('Our Team') }}"
        description="{{ __('Our talented team that actually does not exist. But we pretend it does to make it look like we have a team.') }}" />

    <div class="mx-auto mt-2 md:mt-8 flex max-w-5xl flex-wrap items-center justify-center gap-10 md:gap-16 p-4 md:p-8 lg:justify-between">
        @foreach($teamMembers as $member)
            <div class="flex flex-col items-center gap-2">
                <div class="relative size-20 sm:size-44 overflow-hidden rounded-full md:size-52">
                    <img 
                        src="{{ $member['image'] }}"
                        alt="{{ $member['name'] }}"
                        class="size-20 sm:size-44 origin-top rounded-full grayscale transition-all duration-500 hover:scale-110 hover:grayscale-0 md:size-52"
                        loading="lazy"
                        decoding="async"
                    >
                </div>
                <h3 class="text-sm sm:heading-4">
                    {{ $member['name'] }}
                </h3>
                <p class="text-xs sm:text-sm font-medium text-primary dark:text-primary-dark">
                    {{ $member['role'] }}
                </p>
            </div>
        @endforeach
    </div>
</div>
