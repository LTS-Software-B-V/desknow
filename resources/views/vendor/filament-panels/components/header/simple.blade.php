@props([
    'heading' => null,
    'logo' => true,
    'subheading' => null,
])

<header class="fi-simple-header flex flex-col items-center">
    @if ($logo)
        <x-filament-panels::logo class="mb-4" />
    @endif



    @if (filled($subheading))
        <p
            class="fi-simple-header-subheading mt-2 text-center text-sm text-gray-500 dark:text-gray-400"
        >
            {{ $subheading }}
        </p>
    @endif
</header>
