@extends('layouts.app')

@section('title', 'お問い合わせフォーム | 確認画面')

@section('css')
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('content')
<section class="confirm-panel">
    <h1 class="confirm-title">Confirm</h1>

    <table class="confirm-table" aria-label="確認内容">
        <tbody>
            <tr>
                <th>お名前</th>
                <td>{{ $form['first_name'] }} {{ $form['last_name'] }}</td>
            </tr>
            <tr>
                <th>性別</th>
                <td>
                    @if ($form['gender'] == 1)
                        男性
                    @elseif ($form['gender'] == 2)
                        女性
                    @else
                        その他
                    @endif
                </td>
            </tr>
            <tr>
                <th>メールアドレス</th>
                <td>{{ $form['email'] }}</td>
            </tr>
            <tr>
                <th>電話番号</th>
                <td>{{ $form['tel1'] . $form['tel2'] . $form['tel3'] }}</td>
            </tr>
            <tr>
                <th>住所</th>
                <td>{{ $form['address'] }}</td>
            </tr>
            <tr>
                <th>建物名</th>
                <td>{{ $form['building'] }}</td>
            </tr>
            <tr>
                <th>お問い合わせの種類</th>
                <td>{{ $category->content ?? '' }}</td>
            </tr>
            <tr>
                <th>お問い合わせ内容</th>
                <td class="multiline">{{ $form['detail'] }}</td>
            </tr>
        </tbody>
    </table>

    <div class="confirm-actions">
        <form class="confirm-actions__form" action="/thanks" method="post">
            @csrf
            <button class="send-btn" type="submit">送信</button>
        </form>
        <a class="edit-link" href="/">修正</a>
    </div>
</section>
@endsection
