@extends('layouts.app')

@section('title', '管理画面')

@section('header_action')
<form class="header-btn-form" action="/logout" method="post">
    @csrf
    <button class="header-btn" type="submit">logout</button>
</form>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
@endsection

@section('content')
<section class="admin-page">
    <h1 class="admin-page__title">Admin</h1>

    <form class="admin-search" action="/search" method="get">
        <input
            class="admin-search__input admin-search__input--keyword"
            type="text"
            name="keyword"
            placeholder="名前やメールアドレスを入力してください"
            value="{{ request('keyword') }}"
        >

        <select class="admin-search__input admin-search__input--select admin-search__input--gender" name="gender">
            <option value="" {{ request('gender') ? '' : 'selected' }}>性別</option>
            <option value="all" {{ request('gender') === 'all' ? 'selected' : '' }}>全て</option>
            <option value="1" {{ request('gender') === '1' ? 'selected' : '' }}>男性</option>
            <option value="2" {{ request('gender') === '2' ? 'selected' : '' }}>女性</option>
            <option value="3" {{ request('gender') === '3' ? 'selected' : '' }}>その他</option>
        </select>

        <select class="admin-search__input admin-search__input--select admin-search__input--category" name="category_id">
            <option value="" {{ request('category_id') ? '' : 'selected' }}>お問い合わせの種類</option>
            @foreach ($categories as $category)
            <option value="{{ $category->id }}"
                {{ (string) request('category_id') === (string) $category->id ? 'selected' : '' }}>
                {{ $category->content }}
            </option>
            @endforeach
        </select>
        <div class="admin-date-picker">
            <input
                class="admin-search__input admin-search__input--date-native"
                type="date"
                name="date"
                value="{{ request('date') }}"
            >
        </div>

        <button class="admin-search__button admin-search__button--search" type="submit">検索</button>
        <a class="admin-search__button admin-search__button--reset" href="/reset">リセット</a>
    </form>

    <div class="admin-toolbar">
        <a class="admin-toolbar__export" href="{{ '/export?' . http_build_query(request()->query()) }}">エクスポート</a>
        <div class="admin-toolbar__pagination">
            @if ($contacts->lastPage() > 1)
            <div class="admin-pagination">
                @if ($contacts->onFirstPage())
                <span class="admin-pagination__item admin-pagination__item--disabled">&lt;</span>
                @else
                <a class="admin-pagination__item" href="{{ $contacts->appends(request()->query())->previousPageUrl() }}">&lt;</a>
                @endif

                @php
                $startPage = max(1, $contacts->currentPage() - 2);
                $endPage = min($contacts->lastPage(), $startPage + 4);
                $startPage = max(1, $endPage - 4);
                @endphp

                @for ($page = $startPage; $page <= $endPage; $page++)
                    @if ($page === $contacts->currentPage())
                    <span class="admin-pagination__item admin-pagination__item--active">{{ $page }}</span>
                    @else
                    <a class="admin-pagination__item" href="{{ request()->fullUrlWithQuery(['page' => $page]) }}">{{ $page }}</a>
                    @endif
                    @endfor

                    @if ($contacts->hasMorePages())
                    <a class="admin-pagination__item" href="{{ $contacts->appends(request()->query())->nextPageUrl() }}">&gt;</a>
                    @else
                    <span class="admin-pagination__item admin-pagination__item--disabled">&gt;</span>
                    @endif
            </div>
            @endif
        </div>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>お名前</th>
                    <th>性別</th>
                    <th>メールアドレス</th>
                    <th>お問い合わせ内容</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($contacts as $contact)
                <tr>
                    <td>{{ $contact->first_name }} {{ $contact->last_name }}</td>
                    <td>
                        @if ($contact->gender === 1)
                        男性
                        @elseif ($contact->gender === 2)
                        女性
                        @else
                        その他
                        @endif
                    </td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->detail }}</td>
                    <td class="admin-table__detail-cell">
                        <a
                            class="admin-table__detail-button"
                            href="{{ '/search?' . http_build_query(array_merge(request()->query(), ['detail_id' => $contact->id])) }}"
                        >
                            詳細
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="admin-table__empty" colspan="5">データがありません</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if (!empty($selectedContact))
    @php
    $genderLabel = $selectedContact->gender === 1 ? '男性' : ($selectedContact->gender === 2 ? '女性' : 'その他');
    @endphp
    <div class="admin-modal-backdrop">
        <div class="admin-modal">
            <a class="admin-modal__close" href="{{ '/search?' . http_build_query(collect(request()->query())->except('detail_id')->all()) }}">&times;</a>

            <div class="admin-modal__row">
                <p class="admin-modal__label">お名前</p>
                <p class="admin-modal__value">{{ $selectedContact->first_name }} {{ $selectedContact->last_name }}</p>
            </div>
            <div class="admin-modal__row">
                <p class="admin-modal__label">性別</p>
                <p class="admin-modal__value">{{ $genderLabel }}</p>
            </div>
            <div class="admin-modal__row">
                <p class="admin-modal__label">メールアドレス</p>
                <p class="admin-modal__value">{{ $selectedContact->email }}</p>
            </div>
            <div class="admin-modal__row">
                <p class="admin-modal__label">電話番号</p>
                <p class="admin-modal__value">{{ $selectedContact->tel }}</p>
            </div>
            <div class="admin-modal__row">
                <p class="admin-modal__label">住所</p>
                <p class="admin-modal__value">{{ $selectedContact->address }}</p>
            </div>
            <div class="admin-modal__row">
                <p class="admin-modal__label">建物名</p>
                <p class="admin-modal__value">{{ $selectedContact->building }}</p>
            </div>
            <div class="admin-modal__row">
                <p class="admin-modal__label">お問い合わせの種類</p>
                <p class="admin-modal__value">{{ optional($selectedContact->category)->content }}</p>
            </div>
            <div class="admin-modal__row admin-modal__row--top">
                <p class="admin-modal__label">お問い合わせ内容</p>
                <p class="admin-modal__value admin-modal__value--multiline">{{ $selectedContact->detail }}</p>
            </div>

            <form class="admin-modal__actions" action="/delete/{{ $selectedContact->id }}" method="post">
                @csrf
                @method('DELETE')
                <input type="hidden" name="keyword" value="{{ request('keyword') }}">
                <input type="hidden" name="gender" value="{{ request('gender') }}">
                <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                <input type="hidden" name="date" value="{{ request('date') }}">
                <button class="admin-modal__delete" type="submit">削除</button>
            </form>
        </div>
    </div>
    @endif
</section>
@endsection
