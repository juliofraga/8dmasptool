@extends('layouts.app_admin')

@section('content')
    <perfil-component :user='@json(Auth::user())'></perfil-component>
@endsection