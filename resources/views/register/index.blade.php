@extends('layouts.base')

@section('content')
<form method="POST" action="{{ route('register.store') }}">
    @csrf
 
    {{-- Имя пользователя: --}}
    <label for="name">Name: </label> <input type="text" name="name" value="Giovanni Giorgio">
    <br>
 
    {{-- Email:  --}}
    <label for="email">Email: </label> <input type="email" name="email" value="GG@mail.com">
    <br>
 
    {{-- Пароль:  --}}
    <label for="password">Password: </label> <input type="password" name="password" id="password" value="1234">
    <br>
 
    {{-- Подтверждение пароля: --}}
    <label for="password_confirmation">Confirm password: </label> <input type="password" name="password_confirmation" value="1234">
    </br>
 
    <button type="submit">Register</button>
 </form>
@endsection