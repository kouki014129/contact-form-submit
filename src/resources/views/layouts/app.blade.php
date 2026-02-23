<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  @yield('css')
</head>

<body class="page-bg">
  <header class="site-header">
    <div class="site-header__inner">
      <p class="site-logo">FashionablyLate</p>
      <div class="site-header__action">
        @yield('header_action')
      </div>
    </div>
  </header>

  <main class="page-main">
    @yield('content')
  </main>
</body>

</html>
