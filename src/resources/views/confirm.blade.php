@extends('layouts/app_contact')

@section('css')
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}" />
@endsection

@yield('header_link')
@section('content')

<div class="confirm__heading">
    <h2 class="c-heading">Confirm</h2>
</div>
<form class="form" action="{{ route('contacts.submit') }}" method="post">
    @csrf
    <div class="confirm-table">
        <table class="confirm-table__inner">
            <tr class="confirm-table__row">
                <th class="confirm-table__header">お名前</th>
                <td class="confirm-table__text">
                    <input type="text" name="name" value="{{ $contact['first_name']}}&nbsp;{{ $contact['last_name']}}" />
                    <input type="hidden" name="first_name" value="{{ $contact['first_name']}}" />
                    <input type="hidden" name="last_name" value="{{ $contact['last_name']}}" />
                </td>
            </tr>
            <tr class="confirm-table__row">
                <th class="confirm-table__header">性別</th>
                <td class="confirm-table__text">
                    <input type="hidden" name="gender" value="{{ $contact['gender']}}" />
                    @if ($contact['gender'] == '1')
                    男性
                    @elseif ($contact['gender'] == '2')
                    女性
                    @elseif ($contact['gender'] == '3')
                    その他
                    @endif
                </td>
            </tr>
            <tr class="confirm-table__row">
                <th class="confirm-table__header">メールアドレス</th>
                <td class="confirm-table__text">
                    <span>{{ $contact['email']}}</span>
                    <input type="hidden" name="email" value="{{ $contact['email']}}" />
                </td>
            </tr>
            <tr class="confirm-table__row">
                <th class="confirm-table__header">電話番号</th>
                <td class="confirm-table__text">
                    <span>{{ $contact['tell1'] }}{{ $contact['tell2'] }}{{ $contact['tell3'] }}</span>
                    <input type="hidden" name="tell" value="{{ $contact['tell1']}}{{ $contact['tell2'] }}{{ $contact['tell3'] }}" />
                </td>
            </tr>
            <tr class="confirm-table__row">
                <th class="confirm-table__header">住所</th>
                <td class="confirm-table__text">
                    <span>{{ $contact['address']}}</span>
                    <input type="hidden" name="address" value="{{ $contact['address']}}" />
                </td>
            </tr>
            <tr class="confirm-table__row">
                <th class="confirm-table__header">建物名</th>
                <td class="confirm-table__text">
                    <span>{{ $contact['building'] }}</span>
                    <input type="hidden" name="building" value="{{ $contact['building'] }}" />
                </td>
            </tr>
            <tr class="confirm-table__row">
                <th class="confirm-table__header">
                    お問い合わせの種類
                </th>
                <td class="confirm-table__text">
                    @foreach($categories as $category)
                    @if ($contact['category_id'] == $category->id){{ $category->content }}
                    <input type="hidden" name="selected_category_id" value="{{ $category->id }}" />
                    @endif
                    @endforeach
                </td>
            </tr>
            <tr class="confirm-table__row">
                <th class="confirm-table__header">お問い合わせ内容</th>
                <td class="confirm-table__text">
                    <span>{{ $contact['detail'] }}</span>
                    <input type="hidden" name="detail" value="{{ $contact['detail'] }}" />
                </td>
            </tr>
        </table>
    </div>
    <div class="form__button">
        <button type="submit" class="form__button-submit" name="submit_action" value="submit">
            送信
        </button>
        <button type="submit" class="form__button-edit" name="submit_action" value="edit">
            修正
        </button>
    </div>
</form>
@endsection
