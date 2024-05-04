<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionablyLate</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common_admin.css') }}">
    @yield('css')

</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header-utilities">
                <div class="header__logo__box">
                    <a class="header__logo" href="/register">
                        FashionablyLate
                    </a>
                </div>
                @yield('heading__link')
            </div>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>


</html>
