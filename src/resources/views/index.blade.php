@extends('layouts.app_contact')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="contact-form__content">
    <div class="contact-form__heading">
        <h3 class="cf-heading">
            Contactc
        </h3>
    </div>
    <div class="contact-form">
        <form class="form" action="/contacts/confirm" method="post">
            @csrf
            @php
            $contact = session('contact');
            @endphp
            <div class="form__group">
                <div class="name__group-title">
                    <span class="form__label--item">
                        お名前
                    </span>
                    <span class="form__label--required">
                        ＊
                    </span>
                </div>
                <div class="form__group-content">
                    <div class="name__input--text">
                        <input type="text" name="first_name" placeholder="例）山田" value="{{ $contact['first_name'] ?? old('first_name')}}" />
                        <input type="text" name="last_name" placeholder="例）太郎" value="{{ $contact['last_name'] ?? old('last_name')}}" />
                    </div>
                    <div class="form__error">
                        @error('first_name')
                        {{ $message }}
                        @enderror
                        @error('last_name')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">
                        性別
                    </span>
                    <span class="form__label--required">
                        ＊
                    </span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--radio">
                        <input id="gender-radio1" class="gender-radio" type="radio" name="gender" value="1" {{ $contact['gender'] ??  old('gender')=='1' || old('gender')=='' ? 'checked' : '' }} />
                        <label class="gender-radio-label" for="gender-radio1">男性</label>
                        <input id="gender-radio2" class="gender-radio" type="radio" name="gender" value="2" {{ $contact['gender'] ?? old('gender')=='2' ? 'checked' : '' }} />
                        <label class="gender-radio-label" for="gender-radio2">女性</label>
                        <input id="gender-radio3" class="gender-radio" type="radio" name="gender" value="3" {{ $contact['gender'] ?? old('gender')=='3' ? 'checked' : '' }} />
                        <label class="gender-radio-label" for="gender-radio3">その他</label>
                    </div>
                    <div class="form__error">
                        @error('gender')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">
                        メールアドレス
                    </span>
                    <span class="form__label--required">＊</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="email" name="email" value="{{ $contact['email'] ?? old('email')}}" placeholder="test@example.com" />
                    </div>
                    <div class="form__error">
                        @error('email')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">電話番号</span>
                    <span class="form__label--required">＊</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--tel">
                        <input type="tel" name="tell1" value="{{ $contact['tell1'] ?? old('tell1') }}" placeholder="090" />
                        <span class="tel">-</span>
                        <input type="tel" name="tell2" value="{{ $contact['tell2'] ?? old('tell2') }}" placeholder="1234" />
                        <span class="tel">-</span>
                        <input type="tel" name="tell3" value="{{ $contact['tell3'] ?? old('tell3') }}" placeholder="5678" />
                    </div>
                    <div class="form__error">
                        @error('tell1')
                        {{ $message }}
                        @enderror
                        @error('tell2')
                        {{ $message }}
                        @enderror
                        @error('tell3')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">
                        住所
                    </span>
                    <span class="form__label--required">＊</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="text" name="address" value="{{ $contact['address'] ?? old('address')}}" placeholder="東京都渋谷区千駄ヶ谷1-2-3" />
                    </div>
                    <div class="form__error">
                        @error('address')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">
                        建物名
                    </span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="text" name="building" value="{{ $contact['building'] ?? old('building')}}" placeholder="千駄ヶ谷マンション101" />
                    </div>
                </div>
            </div>
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">
                        お問い合わせの種類
                    </span>
                    <span class="form__label--required">＊</span>
                </div>
                <div class="form__group-content">
                    <select class="create-form__item-select" name="category_id">
                        <option class="form-select" value="{{old('category_id')}}">
                            選択してください
                        </option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $contact && $contact['category_id'] == $category->id ? 'selected' : '' }}>
                                {{ $category->content }}
                            </option>
                        @endforeach
                    </select>
                    <div class="form__error">
                        @error('category_id')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">
                        お問い合わせ内容
                    </span>
                    <span class="form__label--required">＊</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--textarea">
                        <textarea name="detail" placeholder="お問い合わせの内容をご記載ください" >{{ $contact['detail'] ?? old('detail')}}</textarea>
                        <div class="form__error">
                            @error('detail')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="form__button">
                <button class="form__button-submit" type="submit">
                    確認画面
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
