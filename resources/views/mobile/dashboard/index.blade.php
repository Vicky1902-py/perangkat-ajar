@extends('layouts.mobile')

@section('title', 'Dashboard SuperApp Guru SMK')

@section('header')
    {{-- Topbar profil guru SMK dengan verified seal & logo terintegrasi di dalam komponen --}}
@endsection

@section('content')
    @include('components.mobile-app-shell')
@endsection
