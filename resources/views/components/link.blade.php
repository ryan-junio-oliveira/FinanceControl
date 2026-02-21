{{--
    Link component for styled anchor tags.  This mirrors the existing x-button styles
    but always renders an <a> element.  It exists to make intent clearer when you are
    rendering a link instead of a button and to avoid passing an "href" prop to
    the button component.

    Attributes:
      - variant: primary (default), secondary, ghost
      - href: required destination URL
      - target: optional link target (e.g. "_blank")
    Any additional classes may be supplied via the component's attributes.
--}}
@props(['variant' => 'primary', 'href' => '#', 'target' => null])

@php
    $base = 'inline-flex items-center gap-2 px-4 py-2 rounded-md text-sm font-medium shadow-sm transition';
    switch ($variant) {
        case 'secondary':
            $color = 'border bg-white text-gray-700 hover:bg-gray-50';
            break;
        case 'ghost':
            $color = 'text-gray-600 hover:bg-gray-50';
            break;
        default:
            $color = 'bg-brand-500 text-white hover:bg-brand-600';
            break;
    }
    $classes = trim("$base $color");
@endphp

<a href="{{ $href }}" @if($target) target="{{ $target }}" @endif {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
