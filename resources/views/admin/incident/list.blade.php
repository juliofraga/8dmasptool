@extends('layouts.app_admin')

@section('content')
    <incidents-component :user='@json(Auth::user())'></incidents-component>
@endsection