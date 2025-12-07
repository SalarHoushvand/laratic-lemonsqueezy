@props([
    'headClass' => '',
    'bodyClass' => '',
])

<div
    {{ $attributes->merge(['class' => 'overflow-hidden overflow-x-auto rounded-radius border border-outline dark:border-outline-dark']) }}>
    <table class="w-full text-left text-xs sm:text-sm text-on-surface dark:text-on-surface-dark">
        <thead
            class="{{ $headClass }} border-b border-outline bg-surface-alt text-xs sm:text-sm text-on-surface-strong dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark-strong [&_th]:p-2 sm:[&_th]:p-4">
            <tr>
                {{ $head }}
            </tr>
        </thead>

        <tbody
            class="{{ $bodyClass }} divide-y divide-outline bg-surface dark:divide-outline-dark dark:bg-surface-dark [&_td]:p-2.5 sm:[&_td]:p-4">
            {{ $body }}
        </tbody>
    </table>
</div>
