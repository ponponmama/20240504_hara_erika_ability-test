@extends('layouts.app_admin')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

<div class="login__content">
    @section('heading__link')
    <div class="header__button">
        <a href="/register">
            <button class="header-nav__button">
                register
            </button>
        </a>
    </div>
    @endsection
    @section('content')
    <div class="login-form__heading">
        <h3 class="lf-heading">
            Login
        </h3>
    </div>
    <div class="login-form">
        <form class="form" action="/login" method="post">
            @csrf
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
            </div>
            <div class="form__button">
                <button class="form__button-submit" type="submit">
                    ログイン
                </button>
            </div>
    </div>
    </form>
</div>
@endsection