@extends('layouts.app')

@section('title', '会員登録画面')

@section('header_action')
<a class="header-btn" href="/login">login</a>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<section class="auth-page">
    <h1 class="auth-page__title">Register</h1>

    <div class="auth-page__card auth-page__card--register">
        <form class="auth-form auth-form--register" action="/register" method="post">
            @csrf

            <div class="auth-form__group">
                <label class="auth-form__label" for="name">お名前</label>
                <input class="auth-form__input" id="name" type="text" name="name" placeholder="例: 山田  太郎" value="{{ old('name') }}">
                @error('name')
                <p class="auth-form__error">{{ $message }}</p>
                @enderror
            </div>

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
            </div>

            <div class="auth-form__actions">
                <button class="auth-form__submit" type="submit">登録</button>
            </div>
        </form>
    </div>
</section>
@endsection
