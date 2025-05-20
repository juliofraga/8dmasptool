@extends('layouts.app_admin')

@section('content')
    <profile-component :user='@json(Auth::user())'></profile-component>
@endsection