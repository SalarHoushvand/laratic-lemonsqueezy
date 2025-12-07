@props([
    'steps' => ['Create an account', 'Select a plan', 'Checkout', 'Get started'], 
    'current' => 1, 
])

<ol class="flex w-full items-center gap-2" aria-label="progress steps">

    @foreach ($steps as $index => $label)
        @php
            $stepNumber = $index + 1;
            $isFirst = $index === 0;
            $isCompleted = $stepNumber < $current;
            $isCurrent = $stepNumber === $current;
        @endphp
        @if ($isFirst)
            <li class="text-sm" @if ($isCurrent) aria-current="step" @endif
                aria-label="{{ strtolower($label) }}">
                <div class="flex items-center gap-2">
                    @if ($isCompleted)
                        <span
                            class="flex size-5 items-center justify-center rounded-full border border-primary bg-primary text-on-primary dark:border-primary-dark dark:bg-primary-dark dark:text-on-primary-dark">
                            <x-icons.check variant="micro" size="md" title="completed" />
                        </span>
                        <span class="hidden w-max text-primary dark:text-primary-dark sm:inline">
                            {{ $label }}
                        </span>
                    @elseif ($isCurrent)
                        <span
                            class="flex size-5 items-center justify-center rounded-full border border-primary bg-primary font-bold text-on-primary outline outline-2 outline-offset-2 outline-primary dark:border-primary-dark dark:bg-primary-dark dark:text-on-primary-dark dark:outline-primary-dark">
                            {{ $stepNumber }}
                        </span>
                        <span class="hidden w-max font-bold text-primary dark:text-primary-dark sm:inline">
                            {{ $label }}
                        </span>
                    @else
                        {{-- first step being "upcoming" is unlikely but handled anyway --}}
                        <span
                            class="flex size-5 items-center justify-center rounded-full border border-outline bg-surface-alt font-medium text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark">
                            {{ $stepNumber }}
                        </span>
                        <span class="hidden w-max text-on-surface dark:text-on-surface-dark sm:inline">
                            {{ $label }}
                        </span>
                    @endif
                </div>
            </li>

        @else
            <li class="flex w-full items-center text-sm" @if ($isCurrent) aria-current="step" @endif
                aria-label="{{ strtolower($label) }}">
                {{-- line before the step --}}
                <span
                    class="h-0.5 w-full
                        @if ($isCompleted || $isCurrent) bg-primary dark:bg-primary-dark
                        @else
                            bg-outline dark:bg-outline-dark @endif"
                    aria-hidden="true"></span>

                <div class="flex items-center gap-2 pl-2">
                    @if ($isCompleted)
                        <span
                            class="flex size-5 shrink-0 items-center justify-center rounded-full border border-primary bg-primary text-on-primary dark:border-primary-dark dark:bg-primary-dark dark:text-on-primary-dark">
                            <x-icons.check variant="micro" size="md" title="completed" />
                        </span>
                        <span class="hidden w-max text-primary dark:text-primary-dark sm:inline">
                            {{ $label }}
                        </span>
                    @elseif ($isCurrent)
                        <span
                            class="flex size-5 shrink-0 items-center justify-center rounded-full border border-primary bg-primary font-bold text-on-primary outline outline-2 outline-offset-2 outline-primary dark:border-primary-dark dark:bg-primary-dark dark:text-on-primary-dark dark:outline-primary-dark">
                            {{ $stepNumber }}
                        </span>
                        <span class="hidden w-max font-bold text-primary dark:text-primary-dark sm:inline">
                            {{ $label }}
                        </span>
                    @else
                        <span
                            class="flex size-5 shrink-0 items-center justify-center rounded-full border border-outline bg-surface-alt font-medium text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark">
                            {{ $stepNumber }}
                        </span>
                        <span class="hidden w-max text-on-surface dark:text-on-surface-dark sm:inline">
                            {{ $label }}
                        </span>
                    @endif
                </div>
            </li>
        @endif
    @endforeach

</ol>
