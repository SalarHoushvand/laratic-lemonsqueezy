@php
    $listings = [
        [
            'title' => 'Software Engineer',
            'location' => 'Remote',
            'type' => 'Full-time',
            'description' =>
                'We are looking for a software engineer with a passion for building scalable and efficient systems.',
            'url' => '#',
        ],
        [
            'title' => 'UI/UX Designer',
            'location' => 'Hybrid',
            'type' => 'Full-time',
            'description' =>
                'Join our design team to create beautiful and intuitive user experiences for our cloud platform.',
            'url' => '#',
        ],
        [
            'title' => 'DevOps Engineer',
            'location' => 'Remote',
            'type' => 'Full-time',
            'description' => 'Help us build and maintain our cloud infrastructure and deployment pipelines.',
            'url' => '#',
        ],
    ];
@endphp
<div {{ $attributes }}>
    <h2 class="heading-3">
        {{ __('Open Positions') }}
    </h2>
    <div class="flex flex-col gap-4 mt-8 divide-y divide-outline dark:divide-outline-dark">
        @foreach ($listings as $listing)
            <article class="flex flex-col gap-4 py-6">
                <div class="flex gap-4 justify-between">
                    <h3 class="heading-4">
                        {{ __($listing['title']) }}
                    </h3>
                    <x-button :href="$listing['url']" target="_blank">{{ __('Apply Now') }} <x-icons.arrow-top-right-on-square
                            size="sm" /></x-button>
                </div>
                <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
                    {{ __($listing['description']) }}
                </p>
                <div class="flex gap-6">
                    <div class="flex items-center gap-2">
                        <x-icons.map-pin variant="mini" size="md" />
                        <span>{{ $listing['location'] }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <x-icons.clock variant="mini" size="md" />
                        <span>{{ $listing['type'] }}</span>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
</div>
