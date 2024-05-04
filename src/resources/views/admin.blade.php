@extends('layouts.app_admin')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

<div class="admin__content">
    @section('heading__link')
    <div class="header__button">
        <a href="{{ route('logout') }}" class="header-nav__button">
            logout
        </a>
    </div>
    @endsection
    @section('content')
    <div class="admin-form__heading">
        <h3 class="af-heading">
            Admin
        </h3>
        <div class="admin-form">
            <form class="search-form" action="{{ route('admin.search') }}" method="get">
                @csrf
                @php
                    $searchConditions = session('search_conditions');
                @endphp
                <div class="admin__item-heading">
                    <div class="admin__item">
                        <div class="search-form__item">
                            <input class="search-form" type="text" name="keyword"  value="{{ $searchConditions['keyword'] ?? '' }}" placeholder="名前やメールアドレスを入力してください"/>
                        </div>
                        <div class="arrow__gender">
                            <select name="gender">
                                <option value="">性別</option>
                                <option value="1" {{ $searchConditions['gender'] ?? ' ' == 1 ? 'selected' : '' }}>男性</option>
                                <option value="2" {{ $searchConditions['gender'] ?? ' ' == 2 ? 'selected' : '' }}>女性</option>
                                <option value="3" {{ $searchConditions['gender'] ?? ' ' == 3 ? 'selected' : '' }}>その他</option>
                            </select>
                            <div class="arrow__down"></div>
                        </div>
                        <div class="arrow__enquiry">
                            <select class="select-form" name="category_id">
                                <option value="" placeholder="お問い合わせの種類">お問い合わせの種類</option>
                                @if(isset($categories))
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $searchConditions['category_id'] ?? ' ' == $category->id ? 'selected' : '' }}>
                                            {{ $category->content }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="arrow__down"></div>
                        </div>
                        <div class="arrow__date">
                            <label class="date__edit">
                                <input class="input__date" name="date" type="date" value="{{ $searchConditions['date'] ?? ' ' }}" placeholder="年/月/日" />
                            </label>
                        </div>
                        <div class="arrow__down"></div>
                        <button class="search__button" type="submit">
                            検索
                        </button>
                        <a href="{{ route('admin.reset_search') }}" class="reset__button">リセット</a>
                    </div>
                    <div class="middle__admin">
                        <div class="button__export">
                            <a href="{{ route('admin.contacts.export_csv') }}" class="contact__export">
                                エクスポート
                            </a>
                        </div>
                        <div class="admin__pagination">
                            {{$contacts->links()}}
                        </div>
                    </div>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('redirect_success'))
                        <meta http-equiv="refresh" content="3;url={{ route('admin.index') }}">
                        @php
                            session()->forget('redirect_success');
                        @endphp
                    @endif
                    <div class="listing__hail">
                        <table id="contact__table">
                            <tr>
                                <th>お名前</th>
                                <th>性別</th>
                                <th>メールアドレス</th>
                                <th>お問い合わせの種類</th>
                                <th>お問い合わせの内容</th>
                                <th></th>
                            </tr>
                            @foreach($contacts as $contact)
                            <tr>
                                <td style="display:none;">{{ $contact->id }}</td>
                                <td>{{ $contact->first_name }} {{ $contact->last_name }}</td>
                                <td> @if($contact->gender == 1) 男性 @elseif($contact->gender == 2) 女性 @else その他 @endif</td>
                                <td>{{ $contact->email }}</td>
                                <td>{{ $contact->category->content }}</td>
                                <td>
                                    <a href="#modal-{{ $contact->id }}" class="modal_admin"{{ $contact->id }}>詳細</a>
                                </td>
                            </tr>
                                @endforeach
                        </table>
                    </div>
                </div>
            </form>
            @foreach($contacts as $contact)
            <div class="modal-wrapper" id="modal-{{ $contact->id }}">
                <a href="#!" class="modal-overlay"></a>
                <div class="modal-window">
                    <div class="modal-content">
                        <table class="modal_table">
                            <tr>
                                <td><strong>お名前:</strong></td>
                                <td>{{ $contact->first_name }} {{ $contact->last_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>性別:</strong></td>
                                <td>@if($contact->gender == 1) 男性 @elseif($contact->gender == 2) 女性 @else その他 @endif</td>
                            </tr>
                            <tr>
                                <td><strong>メールアドレス</strong></td>
                                <td>{{ $contact->email }}</td>
                            </tr>
                            <tr>
                                <td><strong>電話番号</strong></td>
                                <td>{{ $contact->tell }}</td>
                            </tr>
                            <tr>
                                <td><strong>住所</strong></td>
                                <td>{{ $contact->address }}</td>
                            </tr>
                            <tr>
                                <td><strong>建物名:</strong></td>
                                <td>{{ $contact->building }}</td>
                            </tr>
                            <tr>
                                <td><strong>お問い合わせの種類</strong></td>
                                <td>{{ $contact->category->content }}</td>
                            </tr>
                            <tr>
                                <td><strong>お問い合わせの内容</strong></td>
                                <td>{{ $contact->detail }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal_delete"  id="modal-{{ $contact->id }}">
                        <form action="{{ route('admin.destroy', ['id' =>$contact->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('本当に削除しますか？')" class="delete-btn">削除</button>
                        </form>
                        <a href="#!" class="modal-close">
                            ×
                        </a>
                    </div>
                </div>    
            </div>
            @endforeach        
        </div>
    </div>
    @endsection
</div>
