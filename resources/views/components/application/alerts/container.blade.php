@props([
    'position' => 'top-right',
    'maxWidth' => 'max-w-sm'
])

@php
$positionClasses = [
    'top-right' => 'fixed top-24 right-6',
    'top-left' => 'fixed top-24 left-6',
    'bottom-right' => 'fixed bottom-6 right-6',
    'bottom-left' => 'fixed bottom-6 left-6',
    'top-center' => 'fixed top-24 left-1/2 -translate-x-1/2',
    'bottom-center' => 'fixed bottom-6 left-1/2 -translate-x-1/2',
];

$positionClass = $positionClasses[$position] ?? $positionClasses['top-right'];
@endphp

<div
    id="alert-container"
    class="{{ $positionClass }}
           z-[99999]
           {{ $maxWidth }}
           w-full sm:w-auto
           flex flex-col gap-3
           pointer-events-none"
>
    <div class="flex flex-col gap-3 pointer-events-auto">

        @if (session('success'))
            <x-application.alerts.alert-message 
                type="success" 
                :message="session('success')" 
                :duration="5000"
            />
        @endif

        @if (session('error'))
            <x-application.alerts.alert-message 
                type="error" 
                :message="session('error')" 
                :duration="7000"
            />
        @endif

        @if (session('warning'))
            <x-application.alerts.alert-message 
                type="warning" 
                :message="session('warning')" 
                :duration="6000"
            />
        @endif

        @if (session('info'))
            <x-application.alerts.alert-message 
                type="info" 
                :message="session('info')" 
                :duration="5000"
            />
        @endif

        {{ $slot }}

    </div>
</div>