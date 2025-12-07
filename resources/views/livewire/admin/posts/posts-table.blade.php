@props([
    'searchable' => true,
])

<div class="flex flex-col gap-4">
    <div class="flex items-center gap-4 justify-between w-full">
        @if ($searchable)
            <!-- Search Input: Live search functionality for filtering posts -->
            <div class="w-full flex-1 md:max-w-xs">
                <x-input wire:model.live="search" variant="search" :placeholder="__('Search posts...')"
                    :aria-label="__('Search posts')" />
            </div>
        @endif
        <x-button variant="primary" href="{{ route('admin.posts.create') }}" :aria-label="__('Create new post')">
            {{ __('Create new post') }}
        </x-button>
    </div>

    <!-- Empty state: Displayed when no posts are found -->
    @if ($posts->isNotEmpty())
        <!-- Posts table: Main table displaying all posts -->
        <x-table>
            <x-slot:head>
                <th scope="col" class="min-w-44">{{ __('Title') }}</th>
                <th scope="col" class="hidden md:table-cell text-center">{{ __('Author') }}</th>
                <th scope="col" class="text-center">
                    <button type="button" wire:click="toggleActive"
                        class="w-full flex items-center justify-center gap-1 cursor-pointer transition-colors rounded-radius px-2 py-1 {{ $filterActive ? 'font-semibold text-primary dark:text-primary-dark' : 'hover:text-on-surface-strong dark:hover:text-on-surface-dark-strong hover:bg-surface-dark/5 dark:hover:bg-surface/5' }}">
                        {{ __('Active') }}
                        <x-icons.chevron-up-down variant="mini" size="sm"
                            class="{{ $filterActive ? 'text-primary dark:text-primary-dark' : '' }}" />
                    </button>
                </th>
                <th scope="col" class="text-center">
                    <button type="button" wire:click="togglePromoted"
                        class="w-full flex items-center justify-center gap-1 cursor-pointer transition-colors rounded-radius px-2 py-1 {{ $filterPromoted ? 'font-semibold text-primary dark:text-primary-dark' : 'hover:text-on-surface-strong dark:hover:text-on-surface-dark-strong hover:bg-surface-dark/5 dark:hover:bg-surface/5' }}">
                        {{ __('Promoted') }}
                        <x-icons.chevron-up-down variant="mini" size="sm"
                            class="{{ $filterPromoted ? 'text-primary dark:text-primary-dark' : '' }}" />
                    </button>
                </th>
                <th scope="col" class="text-center">
                    <button type="button" wire:click="toggleUpdated"
                        class="w-full flex items-center justify-center gap-1 cursor-pointer transition-colors rounded-radius px-2 py-1 {{ $sortUpdated !== null ? 'font-semibold text-primary dark:text-primary-dark' : 'hover:text-on-surface-strong dark:hover:text-on-surface-dark-strong hover:bg-surface-dark/5 dark:hover:bg-surface/5' }}">
                        {{ __('Updated') }}
                        @if ($sortUpdated === 'desc')
                            <x-icons.arrow-down variant="mini" size="sm"
                                class="text-primary dark:text-primary-dark" />
                        @elseif ($sortUpdated === 'asc')
                            <x-icons.arrow-up variant="mini" size="sm"
                                class="text-primary dark:text-primary-dark" />
                        @else
                            <x-icons.chevron-up-down variant="mini" size="sm" />
                        @endif
                    </button>
                </th>
                <th scope="col" class="text-center">{{ __('Language') }}</th>
                <th scope="col" class="text-center">{{ __('Actions') }}</th>
            </x-slot:head>

            <x-slot:body>
                @foreach ($posts as $post)
                    <tr wire:key="post-{{ $post->id }}">
                        <!-- Post title with link to edit page -->
                        <td class="max-w-44">
                            <a href="{{ route('admin.posts.edit', ['post' => $post->id]) }}">{{ $post->title }}</a>
                        </td>

                        <!-- Author name -->
                        <td class="hidden md:table-cell text-center">{{ $post->author }}</td>

                        <!-- Active status: Check icon if active, minus icon if inactive -->
                        <td class="text-center">
                            @if ($post->is_active)
                                <x-badge variant="outline-success" size="xs">
                                    {{ __('Active') }}
                                </x-badge>
                            @else
                                <x-icons.minus variant="solid" size="sm"
                                    class="text-on-surface/50 dark:text-on-surface-dark/50 mx-auto" />
                            @endif
                        </td>

                        <!-- Promoted status: Check icon if promoted, minus icon if not -->
                        <td class="text-center">
                            @if ($post->is_promoted)
                                <x-badge variant="outline-primary" size="xs">
                                    {{ __('Promoted') }}
                                </x-badge>
                            @else
                                <x-icons.minus variant="solid" size="sm"
                                    class="text-on-surface/50 dark:text-on-surface-dark/50 mx-auto" />
                            @endif
                        </td>

                        <!-- Last updated timestamp (human readable) -->
                        <td class="text-center text-xs font-bold">{{ $post->updated_at->diffForHumans() }}</td>

                        <!-- Language flag icon -->
                        <td class="text-center">
                            <img class="w-5 h-3 object-cover mx-auto"
                                src="https://flagcdn.com/{{ config("languages.$post->language.flag", 'gb') }}.svg"
                                alt="{{ config("languages.$post->language.name", 'English') }}" aria-hidden="true"
                                title="{{ config("languages.$post->language.name", 'English') }}" />
                        </td>

                        <!-- Action buttons: Delete and Edit -->
                        <td class="text-center">
                            <div class="flex items-center justify-center gap-2">
                                <!-- Delete post modal trigger -->
                                <x-modal-trigger target="delete-post-{{ $post->id }}">
                                    <x-tooltip :text="__('Delete post')" position="top">
                                        <x-button variant="ghost" size="xs" :title="__('Delete post')" :aria-label="__('Delete post')">
                                            <x-icons.trash variant="outline" size="md" class="text-danger" />
                                        </x-button>
                                    </x-tooltip>
                                </x-modal-trigger>
                                <!-- Edit post button -->
                                <x-tooltip :text="__('Edit post')" position="top" class="hidden md:block">
                                    <x-button variant="ghost" size="xs" :title="__('Edit post')" :aria-label="__('Edit post')"
                                        href="{{ route('admin.posts.edit', ['post' => $post->id]) }}">
                                        <x-icons.pencil variant="outline" size="md"
                                            class="text-primary dark:text-primary-dark" />
                                    </x-button>
                                </x-tooltip>
                            </div>
                        </td>
                    </tr>

                    <!-- Delete post modal: Confirmation dialog for post deletion -->
                    <x-modal maxWidth="lg" name="delete-post-{{ $post->id }}">
                        <x-slot:header>
                            <p class="font-medium text-on-surface-strong dark:text-on-surface-dark-strong">
                                {{ __('You are about to delete a post permanently.') }}
                            </p>
                        </x-slot:header>

                        <!-- Modal content: Warning message and post details -->
                        <div class="space-y-2 p-4">
                            <p class="text-sm font-medium text-on-surface dark:text-on-surface-dark">
                                {{ __('Post:') }} <span class="font-semibold">{{ $post->title }}</span>
                            </p>
                            <p class="text-sm text-on-surface dark:text-on-surface-dark">
                                {{ __('Once you delete the post, you can no longer recover it. This action cannot be undone.') }}
                            </p>
                        </div>

                        <x-slot:footer>
                            <!-- Cancel button: Closes the modal -->
                            <x-button variant="ghost" type="button" x-on:click="modalIsOpen = false"
                                class="w-full md:w-fit">
                                {{ __('Cancel') }}
                            </x-button>

                            <!-- Delete button: Confirms and executes post deletion -->
                            <x-button variant="danger" type="button" wire:click="delete({{ $post->id }})"
                                class="w-full md:w-fit" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="delete">
                                    {{ __('Delete Post') }}
                                </span>
                                <span wire:loading wire:target="delete">
                                    {{ __('Deleting...') }}
                                </span>
                            </x-button>
                        </x-slot:footer>
                    </x-modal>
                @endforeach
            </x-slot:body>
        </x-table>

        <!-- Pagination: Navigate between pages of posts -->
        <div>
            {{ $posts->links() }}
        </div>
    @else
        <x-blocks.empty-state icon="document" class="h-[50svh]" title="{{ __('No posts') }}"
            description="{{ __('No posts found.') }}">
            <x-button class="mt-2" variant="outline" size="xs" href="{{ route('admin.posts.create') }}"
                :aria-label="__('Create new post')">
                {{ __('Create a New Post') }}
            </x-button>
        </x-blocks.empty-state>
    @endif
</div>
