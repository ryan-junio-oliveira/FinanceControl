@props([
    'position' => 'top-right',
    'maxWidth' => 'max-w-sm'
])

@php
$positionClasses = [
    'top-right' => 'fixed top-20 right-6 z-[99999]',
    'top-left' => 'fixed top-20 left-6 z-[99999]',
    'bottom-right' => 'fixed bottom-6 right-6 z-[99999]',
    'bottom-left' => 'fixed bottom-6 left-6 z-[99999]',
    'top-center' => 'fixed top-20 left-1/2 -translate-x-1/2 z-[99999]',
    'bottom-center' => 'fixed bottom-6 left-1/2 -translate-x-1/2 z-[99999]',
];

$positionClass = $positionClasses[$position] ?? $positionClasses['top-right'];
@endphp

<div class="{{ $positionClass }} {{ $maxWidth }} w-auto space-y-3" id="alert-container">

    @if (session('success'))
        <x-application.alerts.alert-message 
            type="success" 
            :message="session('success')" 
            timeout="5000"
        />
    @endif

    @if (session('error'))
        <x-application.alerts.alert-message 
            type="error" 
            :message="session('error')" 
            timeout="7000"
        />
    @endif

    @if (session('warning'))
        <x-application.alerts.alert-message 
            type="warning" 
            :message="session('warning')" 
            timeout="6000"
        />
    @endif

    @if (session('info'))
        <x-application.alerts.alert-message 
            type="info" 
            :message="session('info')" 
            timeout="5000"
        />
    @endif

    {{ $slot }}
</div>