@extends('layouts.app_admin')

@section('content')
    <new-incident-component :user='@json(Auth::user())'></new-incident-component>
@endsection