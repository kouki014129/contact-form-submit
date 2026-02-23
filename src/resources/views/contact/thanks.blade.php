@extends('layouts.app')

@section('title', 'お問い合わせフォーム | 完了')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
<section class="thanks-page">
    <p class="thanks-bg">Thank you</p>

    <div class="thanks-content">
        <h1 class="thanks-message">お問い合わせありがとうございました</h1>
        <a class="thanks-home" href="/">HOME</a>
    </div>
</section>
@endsection
