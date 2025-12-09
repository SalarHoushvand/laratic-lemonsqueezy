<x-layouts.guest>
    @push('head')
        <title>{{ config('app.name', 'Laravel') }} - {{ __('Blog - Insights & Updates from :app', ['app' => config('app.name')]) }}</title>
        <meta name="description"
            content="{{ __('Insights & Updates from :app', ['app' => config('app.name')]) }}">
    @endpush
    <div class="px-6">
        <!-- Polka dot background -->
        <div class="hidden dark:block absolute inset-0 -z-10 bg-pattern pointer-events-none" aria-hidden="true"></div>

        <x-blocks.blog.hero />

        @if($categories->count() > 0)
            <x-blocks.blog.categories class="mb-12 w-full" :categories="$categories" />
        @endif

        <div class="max-w-6xl mx-auto flex flex-col gap-8 md:gap-12 mb-24">
            @isset($featuredPost)
                <div class="w-full max-w-5xl mx-auto">
                    <x-card-post-horizontal :post="$featuredPost" />
                </div>
            @endisset

            @if($posts->count() > 0)
                <div class=" grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 max-w-7xl mx-auto gap-8 md:gap-6">
                    @foreach ($posts as $post)
                        <x-card-post :post="$post" />
                    @endforeach
                </div>

                @if($posts->hasPages())
                    <div class="flex justify-center mt-12">
                        {{ $posts->links() }}
                    </div>
                @endif
            @else
               <x-blocks.empty-state icon="document" title="{{ __('No posts found') }}" description="{{ __('There are no post in this category or language.') }}" />
            @endif
        </div>
        <x-blocks.blog.newsletter id="newsletter-signup" class="my-12" />
    </div>
</x-layouts.guest>
