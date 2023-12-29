<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $site->sitename}}</title>
    <link rel="stylesheet" href="@Css(bootstrap.min.css)">
</head>
<body>
    
    <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="/">Tea</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarColor02">
            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                  <a class="nav-link" href="/pages/about">About</a>
                </li>
              
                @foreach ($categories as $cat)
                    <li class="nav-item">
                      <a class="nav-link" href="/category/{{ $cat }}">{{ $cat }}</a>
                    </li>
                @endforeach

            </ul>

          </div>
        </div>
      </nav>


      <div class="container mt-4">
          @yield('content')
      </div>

</body>
</html>