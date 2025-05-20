@extends('layouts.app_admin')

@section('content')
    <novo-incidente-component :user='@json(Auth::user())'></novo-incidente-component>
@endsection