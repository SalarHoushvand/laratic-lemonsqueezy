@props([
    'author' => [
        'name' => 'John Doe',
        'role' => 'CEO',
        'avatar' => 'https://penguinui.s3.amazonaws.com/component-assets/avatar-1.webp',
    ],
    'quote' =>
        'Simply put, this software transformed my workflow! Its intuitive interface and powerful features make tasks a breeze. A game-changer for productivity!',
])

<article
    {{ $attributes->merge(['class' => 'group text-sm rounded-radius flex max-w-md flex-col border border-outline bg-surface-alt/75 p-6 text-on-surface dark:border-outline-dark dark:bg-surface-dark/75 dark:text-on-surface-dark backdrop-blur-sm']) }}>
    {{-- Quote Icon --}}
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
        class="size-8 text-primary dark:text-primary-dark group-hover:scale-105 transition duration-500 ease-out"
        aria-hidden="true">
        <path
            d="M12 12a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1h-1.388q0-.527.062-1.054.093-.558.31-.992t.559-.683q.34-.279.868-.279V3q-.868 0-1.52.372a3.3 3.3 0 0 0-1.085.992 4.9 4.9 0 0 0-.62 1.458A7.7 7.7 0 0 0 9 7.558V11a1 1 0 0 0 1 1zm-6 0a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1H4.612q0-.527.062-1.054.094-.558.31-.992.217-.434.559-.683.34-.279.868-.279V3q-.868 0-1.52.372a3.3 3.3 0 0 0-1.085.992 4.9 4.9 0 0 0-.62 1.458A7.7 7.7 0 0 0 3 7.558V11a1 1 0 0 0 1 1z" />
    </svg>
    

    {{-- Quote Text --}}
    <p class="mt-2 text-pretty">
        {{ $quote }}
    </p>

    {{-- Author Info --}}
    <div class="flex flex-col-reverse md:flex-row md:items-center mt-8 justify-between gap-6">
        <div class="flex items-center gap-2">
            <img src="{{ $author['avatar'] }}" class="size-10 rounded-full object-cover"
                alt="{{ $author['name'] }}'s avatar" />
            <div class="flex flex-col gap-1">
                <h3 class="font-bold leading-4 text-on-surface-strong dark:text-on-surface-dark-strong">
                    {{ $author['name'] }}
                </h3>
                <span class="text-xs">{{ $author['role'] }}</span>
            </div>
        </div>
    </div>
</article>
