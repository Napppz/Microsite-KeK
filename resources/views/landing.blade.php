@extends('layouts.app')

@section('title', config('event.name') . ' ' . config('event.year') . ' — Akselerasi Investasi Strategis')

@section('content')
    <x-hero />
    <x-overview />
    <x-about />
    <x-agenda />
    <x-location />
    <x-cta-registration />
@endsection
