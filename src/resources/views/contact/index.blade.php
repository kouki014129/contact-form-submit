@extends('layouts.app')

@section('title', 'お問い合わせフォーム | 入力画面')
@section('screen_title', '')

@section('css')
<link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endsection

@section('content')
<section class="contact-panel">
    <h1 class="contact-title">Contact</h1>

    <form class="contact-form" action="/confirm" method="post">
        @csrf

        <div class="contact-form__row">
            <label class="contact-form__label">お名前 <span class="contact-form__required">※</span></label>
            <div>
                <div class="contact-form__split--two">
                    <input class="contact-form__input" type="text" name="first_name" placeholder="例: 山田" value="{{ old('first_name', session('contact_input.first_name')) }}">
                    <input class="contact-form__input" type="text" name="last_name" placeholder="例: 太郎" value="{{ old('last_name', session('contact_input.last_name')) }}">
                </div>
                @error('first_name')<p class="contact-form__error">{{ $message }}</p>@enderror
                @error('last_name')<p class="contact-form__error">{{ $message }}</p>@enderror
            </div>
        </div>

        @php
            $gender = old('gender', session('contact_input.gender', '1'));
        @endphp

        <div class="contact-form__row">
            <label class="contact-form__label">性別 <span class="contact-form__required">※</span></label>
            <div>
                <div class="contact-form__radios">
                    <label>
                        <input class="contact-form__radio" type="radio" name="gender" value="1" {{ $gender == '1' ? 'checked' : '' }}>男性
                    </label>
                    <label>
                        <input class="contact-form__radio" type="radio" name="gender" value="2" {{ $gender == '2' ? 'checked' : '' }}>女性
                    </label>
                    <label>
                        <input class="contact-form__radio" type="radio" name="gender" value="3" {{ $gender == '3' ? 'checked' : '' }}>その他
                    </label>
                </div>

                @error('gender')
                    <p class="contact-form__error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="contact-form__row">
            <label class="contact-form__label">メールアドレス <span class="contact-form__required">※</span></label>
            <div>
                <input class="contact-form__input" type="text" name="email" placeholder="例: test@example.com" value="{{ old('email', session('contact_input.email')) }}">
                @error('email')<p class="contact-form__error">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="contact-form__row">
            <label class="contact-form__label">電話番号 <span class="contact-form__required">※</span></label>
            <div>
                <div class="contact-form__split--tel">
                    <input class="contact-form__input" type="text" name="tel1" inputmode="numeric" placeholder="080" value="{{ old('tel1', session('contact_input.tel1')) }}">
                    <span>-</span>
                    <input class="contact-form__input" type="text" name="tel2" inputmode="numeric" placeholder="1234" value="{{ old('tel2', session('contact_input.tel2')) }}">
                    <span>-</span>
                    <input class="contact-form__input" type="text" name="tel3" inputmode="numeric" placeholder="5678" value="{{ old('tel3', session('contact_input.tel3')) }}">
                </div>
                @if ($errors->has('tel1'))
                    <p class="contact-form__error">{{ $errors->first('tel1') }}</p>
                @elseif ($errors->has('tel2'))
                    <p class="contact-form__error">{{ $errors->first('tel2') }}</p>
                @elseif ($errors->has('tel3'))
                    <p class="contact-form__error">{{ $errors->first('tel3') }}</p>
                @endif
            </div>
        </div>

        <div class="contact-form__row">
            <label class="contact-form__label">住所 <span class="contact-form__required">※</span></label>
            <div>
                <input class="contact-form__input" type="text" name="address" placeholder="例: 東京都渋谷区千駄ヶ谷1-2-3" value="{{ old('address', session('contact_input.address')) }}">
                @error('address')<p class="contact-form__error">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="contact-form__row">
            <label class="contact-form__label">建物名</label>
            <div>
                <input class="contact-form__input" type="text" name="building" placeholder="例: 千駄ヶ谷マンション101" value="{{ old('building', session('contact_input.building')) }}">
            </div>
        </div>

        <div class="contact-form__row">
            <label class="contact-form__label">お問い合わせの種類 <span class="contact-form__required">※</span></label>
            <div>
                <select class="contact-form__select contact-form__select--category" name="category_id">
                    <option value="" {{ old('category_id', session('contact_input.category_id')) ? '' : 'selected' }} disabled>選択してください</option>
                    @foreach (($categories ?? []) as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', session('contact_input.category_id')) == $category->id ? 'selected' : '' }}>
                            {{ $category->content }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')<p class="contact-form__error">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="contact-form__row">
            <label class="contact-form__label">お問い合わせ内容 <span class="contact-form__required">※</span></label>
            <div>
                <textarea class="contact-form__textarea" name="detail" placeholder="お問い合わせ内容をご記載ください">{{ old('detail', session('contact_input.detail')) }}</textarea>
                @error('detail')<p class="contact-form__error">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="contact-form__actions">
            <button class="contact-form__button" type="submit">確認画面</button>
        </div>
    </form>
</section>
@endsection
