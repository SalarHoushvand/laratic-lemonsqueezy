<!-- Users table -->
<x-table>
    <x-slot:head>
        <th scope="col" class="p-4">{{ __('User') }}</th>
        <th scope="col" class="p-4">{{ __('Country') }}</th>
        <th scope="col" class="p-4">{{ __('Member Since') }}</th>
        <th scope="col" class="p-4">{{ __('Subscription') }}</th>
        <th scope="col" class="p-4">{{ __('Action') }}</th>
    </x-slot:head>

    <x-slot:body>
        @foreach ($users as $user)
            <tr>
                <td class="p-4">
                    <a class="flex items-center gap-2 w-max" href="{{ route('admin.users.show', $user) }}">
                        <span
                            class="bg-primary border border-outline dark:border-outline-dark dark:bg-primary-dark flex font-medium items-center justify-center overflow-hidden rounded-full size-10 text-on-primary dark:text-on-primary-dark text-sm tracking-wider">
                            {{ $user->initials() }}
                        </span>

                        <div class="flex flex-col">
                            <span class="text-neutral-900 dark:text-white">
                                {{ $user->name }}
                                @if ($user->hasRole('blocked'))
                                    <span class="text-danger text-sm">
                                        ({{ __('Blocked') }})
                                    </span>
                                @endif
                            </span>
                            <span class="opacity-85 text-neutral-600 dark:text-neutral-300 text-sm">
                                {{ $user->email }}
                            </span>
                        </div>
                    </a>
                </td>
                <td class="p-4">{{ $user->country }}</td>
                <td class="p-4">{{ $user->created_at->format('M d, Y') }}</td>
                <td class="p-4">
                    @if ($user->subscribed())
                        <x-badge variant="primary">{{ $user->currentPlanName() }}</x-badge>
                    @else
                        <x-badge>{{ __('No subscription') }}</x-badge>
                    @endif
                </td>
                <td class="p-4">
                    <a class="active:opacity-100 active:outline-offset-0 bg-transparent dark:outline-primary-dark dark:text-primary-dark focus-visible:outline-2 focus-visible:outline-offset-2 font-semibold hover:opacity-75 outline-primary p-0.5 rounded-radius text-primary whitespace-nowrap"
                        href="{{ route('admin.users.show', $user) }}">
                        {{ __('Edit') }}
                    </a>
                </td>
            </tr>
        @endforeach
    </x-slot:body>
</x-table>

<!-- Pagination -->
<div class="mt-4">
    {{ $users->links() }}
</div>
