@extends('layouts.base')

@section('content')
    <form method="POST" action="/auth/login">
        @csrf
    
        {{-- Email --}}
        <label for="email">Email: </label> <input type="email" name="email" value="gg@mail.com">
        <br>
    
        {{-- Пароль --}}
        <label for="password">Password: </label><input type="password" name="password" id="password" value="1234">
        <br>
    
        {{-- Запомнить меня --}}
        <label for="remember">Remember me: </label> <input type="checkbox" name="remember" checked>
        <br>
    
        <button type="submit">Login</button>
    </form>
@endsection