@extends('layouts.app')

{{-- area admin --}}
{{-- dashboard admin --}}
@if (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin')
        @include('layouts.admin_layout')

        {{-- dashboard admin --}}
        @section('content_right')
            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin')
                @include('app.partial.admin.content-right')
            @endif
        @endsection
    {{-- @elseif () --}}
        
@endif