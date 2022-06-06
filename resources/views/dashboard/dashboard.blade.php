@extends('layouts.app')

{{-- area admin --}}
{{-- dashboard admin --}}
@if (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin')
    @include('layouts.admin_layout')

    {{-- dashboard admin --}}
    @section('content_right')
            @include('app.partial.admin.content-right')
    @endsection

{{-- dashboard guru --}}
@elseif (Auth::user()->role == 'guru')
    @include('layouts.guru-layout')

    @section('content_right')
            @include('app.partial.guru.dashboard-content-right')
    @endsection

@elseif (Auth::user()->role == 'siswa')
    @include('layouts.siswa-layout')

    @section('content_right')
        @include('app.partial.siswa.dashboard-content-right')
    @endsection
@endif