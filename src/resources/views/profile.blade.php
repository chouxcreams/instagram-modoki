<!DOCTYPE html>
<html lang="ja">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <style>
        body {
            background: #f3f3f3;
        }
    </style>
    <title>Instagramもどき</title>
</head>
<div class="container">
    <div class="row mb-10">
        <div class="col-md-6 col-xs-12 offset-md-3">
            <nav class="navbar navbar-expand-sm navbar-dark bg-dark mb-3">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav4" aria-controls="navbarNav4" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-around">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="/">Home</a>
                        </li>
                        @if ($session == 'logout')
                            <li class="nav-item">
                                <a class="nav-link" href="/login">ログイン</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="/logout">ログアウト</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="/post">投稿</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <div class="row mb-10">
        <div class="col-md-6 col-xs-12 offset-md-3">
            <div class="row">
                <div class="col-4">
                    <img class="media-object img-thumbnail" src="{{ $user['icon_file'] }}">
                </div>
                <div class="col-4">
                    {{ $user['name'] }}
                </div>
                <div class="col-4">
                    いいね数合計:{{$user['num_of_likes']}}
                </div>
            </div>
        </div>
    </div>
    @for ($i = 0; $i < ceil(count($posts)/3); $i++)
        <div class="row mb-10">
            <div class="col-md-6 col-xs-12 offset-md-3">
                <div class="row">
                    <div class="col-4">
                        <img class="media-object img-thumbnail" src="{{ $posts[$i * 3]['img_path'] }}">
                    </div>
                    @if ($i * 3 + 1 < count($posts))
                    <div class="col-4">
                        <img class="media-object img-thumbnail" src="{{ $posts[$i * 3 + 1]['img_path'] }}">
                    </div>
                    @endif
                    @if ($i * 3 + 2 < count($posts))
                    <div class="col-4">
                        <img class="media-object img-thumbnail" src="{{ $posts[$i * 3 + 2]['img_path'] }}">
                    </div>
                    @endif
                </div>
            </div>
        </div>
    @endfor
</div>
</body>
</html>