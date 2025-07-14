@extends('layouts.app_admin')

@section('content')
@php
    $segment = request()->segment(4);
    $visualid = (Str::startsWith($segment, 'ID') && strlen($segment) === 10) ? $segment : null;
@endphp
    <corrective-actions-component :user='@json(Auth::user())' :visualid='@json($visualid)'></corrective-actions-component>
@endsection