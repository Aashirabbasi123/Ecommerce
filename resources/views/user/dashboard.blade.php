@extends('user.components.master')

@section('content')
@stack('styles')
@include('user.components.navbar')
@include('user.components.section')
@include('user.components.footer')
@stack('script')
@endsection
