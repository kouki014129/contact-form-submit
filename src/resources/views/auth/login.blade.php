@extends('layouts.app')

@section('title', 'ログイン画面')

@section('header_action')
<a class="header-btn" href="/register">register</a>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<section class="auth-page">
    <h1 class="auth-page__title">Login</h1>

    <div class="auth-page__card auth-page__card--login">
        <form class="auth-form auth-form--login" action="/login" method="post">
            @csrf

            <div class="auth-form__group">
                <label class="auth-form__label" for="email">メールアドレス</label>
                <input class="auth-form__input" id="email" type="email" name="email" placeholder="例: test@example.com" value="{{ old('email') }}">
                @error('email')
                <p class="auth-form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="auth-form__group">
                <label class="auth-form__label" for="password">パスワード</label>
                <input class="auth-form__input" id="password" type="password" name="password" placeholder="例: coachtech1106">
                @error('password')
                <p class="auth-form__error">{{ $message }}</p>
                @enderror
                @error('login')
                <p class="auth-form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="auth-form__actions auth-form__actions--login">
                <button class="auth-form__submit" type="submit">ログイン</button>
            </div>
        </form>
    </div>
</section>
@endsection
