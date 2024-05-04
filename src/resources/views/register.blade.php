@extends('layouts.app_admin')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection


<div class="register__content">
    @section('heading__link')
    <div class="header__button">
        <a href="/login">
            <button class="header-nav__button">
                login
            </button>
        </a>
    </div>
    @endsection
    @section('content')
    <div class="register-form__heading">
        <h3 class="rf-heading">
            register
        </h3>
    </div>
    <div class="register-form">
        <form class="form" action="/register" method="post">
            @csrf
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">
                        お名前
                    </span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="text" name="name" placeholder="例）山田&ensp;太郎" value="{{ old('name') }}" />
                    </div>
                    <div class="form__error">
                        @error('name')
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
                </div>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="email" name="email" placeholder="test@example.com" value="{{ old('email') }}" />
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
                    <span class="form__label--item">
                        パスワード
                    </span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="password" name="password" placeholder="coachtech1106" />
                    </div>
                    <div class="form__error">
                        @error('password')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form__button">
                    <button class="form__button-submit1" type="submit">
                        登録
                    </button>
                </div>
        </form>
    </div>
</div>
@endsection
