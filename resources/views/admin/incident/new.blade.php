@extends('layouts.app_admin')

@section('content')
@php
    $segment = request()->segment(3);
    $visualid = (Str::startsWith($segment, 'ID') && strlen($segment) === 10) ? $segment : null;
@endphp
    <new-incident-component :user='@json(Auth::user())' :visualid='@json($visualid)'></new-incident-component>
@endsection