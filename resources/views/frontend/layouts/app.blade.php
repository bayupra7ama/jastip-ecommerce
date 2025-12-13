<!DOCTYPE html>
<html lang="en">

<head>

    @include('frontend.partials.head')
    <title>{{ $title ?? 'Trift' }}</title>
</head>

<body>

    @include('frontend.partials.preloader')

    @include('frontend.partials.header')

    {{ $slot }}

    @include('frontend.partials.footer')
    @stack('scripts')


</body>

</html>
