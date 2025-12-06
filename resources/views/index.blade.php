@extends('layouts.main')

@section('title', 'Home')

@section('content')

    {{-- HERO SLIDER --}}
    @include('partials.hero')

    {{-- Discount section --}}
    @include('partials.discount')

    {{-- Featured products --}}
    @include('partials.featured-products')

    {{-- Collection --}}
    @include('partials.collections')

    {{-- Latest products --}}
    @include('partials.latest-products')

@endsection
