@props([
    'user' => null,
    'size' => 'md', // sm | md | lg
    'isLink' => true,
    'hasAvatar' => true,
])

@php
    $sizes = [
        'sm' => [
            'avatar' => 'sm',
            'gap' => 'gap-1 sm:gap-1.5',
            'name' => 'text-xs sm:text-sm',
            'email' => 'text-xs',
        ],
        'md' => [
            'avatar' => 'md',
            'gap' => 'gap-1.5 sm:gap-2',
            'name' => 'text-sm sm:text-base',
            'email' => 'text-xs sm:text-sm',
        ],
        'lg' => [
            'avatar' => 'lg',
            'gap' => 'gap-2 sm:gap-3',
            'name' => 'text-base sm:text-lg',
            'email' => 'text-sm sm:text-base',
        ],
    ];

    $sizeConfig = $sizes[$size] ?? $sizes['md'];
@endphp

@if ($isLink)
    <a class="flex items-center {{ $sizeConfig['gap'] }} w-max" href="{{ route('admin.users.show', $user) }}">
        @if ($hasAvatar)
            <x-avatar :img="$user->avatar" :fallback="$user->initials() ?? 'Unknown'" size="{{ $sizeConfig['avatar'] }}" variant="primary" />
        @endif
        <div class="flex flex-col">
            <span class="text-on-surface dark:text-on-surface-dark {{ $sizeConfig['name'] }}">
                {{ $user->name ?? 'Unknown' }}
            </span>
            <span
                class="text-on-surface-muted dark:text-on-surface-dark-muted {{ $sizeConfig['email'] }} max-w-32 text-ellipsis overflow-hidden">
                {{ $user->email ?? 'Unknown' }}
            </span>
        </div>
    </a>
@else
    <div class="flex items-center {{ $sizeConfig['gap'] }} w-max">
        @if ($hasAvatar)
            <x-avatar :img="$user->avatar" :fallback="$user->initials() ?? 'Unknown'" size="{{ $sizeConfig['avatar'] }}" variant="primary" />
        @endif
        <div class="flex flex-col">
            <span
                class="text-on-surface dark:text-on-surface-dark {{ $sizeConfig['name'] }} text-ellipsis overflow-hidden">
                {{ $user->name ?? 'Unknown' }}
            </span>
            <span
                class="text-on-surface-muted dark:text-on-surface-dark-muted {{ $sizeConfig['email'] }} text-ellipsis overflow-hidden max-w-32">
                {{ $user->email ?? 'Unknown' }}
            </span>
        </div>
    </div>
@endif
