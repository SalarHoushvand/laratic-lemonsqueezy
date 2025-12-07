<div>
    @if ($searchable)
        <!-- Search Input -->
        <div class="mb-4">
            <x-input type="search" wire:model.live="search" class="w-full md:max-w-xs" variant="search" :placeholder="__('Search users...')"
                :aria-label="__('Search users')" />
        </div>
    @endif

    @if ($users->isNotEmpty())
        <!-- Users table -->
        <x-table>
            <x-slot:head>
                <th scope="col">{{ __('User') }}</th>
                <th scope="col" class="text-center hidden md:table-cell">{{ __('Roles') }}</th>
                <th scope="col" class="text-center">
                    <button type="button" wire:click="toggleCreated"
                        class="w-full flex items-center justify-center gap-1 cursor-pointer transition-colors rounded-radius px-2 py-1 {{ $sortCreated !== null ? 'font-semibold text-primary dark:text-primary-dark' : 'hover:text-on-surface-strong dark:hover:text-on-surface-dark-strong hover:bg-surface-dark/5 dark:hover:bg-surface/5' }}">
                        {{ __('Joined') }}
                        @if ($sortCreated === 'desc')
                            <x-icons.arrow-down variant="mini" size="sm"
                                class="text-primary dark:text-primary-dark" />
                        @elseif ($sortCreated === 'asc')
                            <x-icons.arrow-up variant="mini" size="sm"
                                class="text-primary dark:text-primary-dark" />
                        @else
                            <x-icons.chevron-up-down variant="mini" size="sm" />
                        @endif
                    </button>
                </th>
                <th scope="col" class="text-center">{{ __('Subscription') }}</th>
                <th scope="col" class="text-center hidden md:table-cell">{{ __('Action') }}</th>
            </x-slot:head>

            <x-slot:body>
                @foreach ($users as $user)
                    <tr wire:key="user-{{ $user->id }}">
                        <td class="p-4">
                            <x-profile-summary :user="$user" />
                        </td>
                        <td class="text-center p-4 hidden md:table-cell">
                            @foreach ($user->roles as $role)
                                <x-badge variant="{{ $role->name === 'blocked' ? 'outline-danger' : 'default' }}" size="xs"
                                    wire:key="role-{{ $role->id }}">{{ ucfirst($role->name) }}</x-badge>
                            @endforeach
                        </td>
                        <td class="text-center p-4">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="text-center p-4">
                            @if ($user->subscribed())
                                <x-badge variant="outline-primary">{{ $user->currentPlanName() }}</x-badge>
                            @else
                                <x-badge>{{ __('No subscription') }}</x-badge>
                            @endif
                        </td>
                        <td class="text-center p-4 hidden md:table-cell">
                            <x-button variant="ghost" href="{{ route('admin.users.show', $user) }}" class="mx-auto">
                                {{ __('Edit') }}
                            </x-button>
                        </td>
                    </tr>
                @endforeach
            </x-slot:body>
        </x-table>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    @else
        <x-blocks.empty-state icon="user-group" class="h-[50svh]" title="{{ __('No users') }}"
            description="{{ __('We couldn’t find any users') }}" />
    @endif

</div>
