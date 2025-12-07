<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

@php
    $theme = config('app.theme', 'laratic');
    $fonts = [
        'denk-one' => ['halloween', 'zombie'],
        'inter' => ['arctic', 'high-contrast', 'news'],
        'jost' => ['christmas'],
        'lato' => ['modern', 'christmas'],
        'merriweather' => ['news'],
        'montserrat' => ['minimal', 'neo-brutalism', 'halloween'],
        'oswald' => ['retro', 'industrial'],
        'playpen-sans' => ['pastel', 'prototype'],
        'poppins' => ['zombie', '90s', 'industrial'],
        'space-mono' => ['neo-brutalism'],
        'instrument-sans' => ['laratic'],
    ];
@endphp

@if (in_array($theme, $fonts['denk-one'] ?? []))
    <!-- Denk One -->
    <link
        href="https://fonts.googleapis.com/css2?family=Denk+One&display=swap"
        rel="stylesheet">
@endif

@if (in_array($theme, $fonts['inter'] ?? []))
    <!-- Inter -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700&display=swap"
        rel="stylesheet">
@endif

@if (in_array($theme, $fonts['jost'] ?? []))
    <!-- Jost -->
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,400&display=swap"
        rel="stylesheet">
@endif

@if (in_array($theme, $fonts['lato'] ?? []))
    <!-- Lato -->
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;1,400&display=swap"
        rel="stylesheet">
@endif

@if (in_array($theme, $fonts['merriweather'] ?? []))
    <!-- Merriweather -->
    <link
        href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700&display=swap"
        rel="stylesheet">
@endif

@if (in_array($theme, $fonts['montserrat'] ?? []))
    <!-- Montserrat -->
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,400&display=swap"
        rel="stylesheet">
@endif

@if (in_array($theme, $fonts['oswald'] ?? []))
    <!-- Oswald -->
    <link
        href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
@endif

@if (in_array($theme, $fonts['playpen-sans'] ?? []))
    <!-- Playpen Sans -->
    <link
        href="https://fonts.googleapis.com/css2?family=Playpen+Sans:wght@400;600&display=swap"
        rel="stylesheet">
@endif

@if (in_array($theme, $fonts['poppins'] ?? []))
    <!-- Poppins -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,700&display=swap"
        rel="stylesheet">
@endif

@if (in_array($theme, $fonts['space-mono'] ?? []))
    <!-- Space Mono -->
    <link
        href="https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400&display=swap"
        rel="stylesheet">
@endif

@if (in_array($theme, $fonts['instrument-sans'] ?? []))
    <!-- Instrument Sans -->
    <link
        href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap"
        rel="stylesheet">
@endif

<!-- ApexCharts loaded via Vite in resources/js/app.js -->
<!-- Scripts -->
@vite(['resources/css/app.css', 'resources/js/app.js'])
