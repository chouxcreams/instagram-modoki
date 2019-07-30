<!DOCTYPE html>
<html lang="ja">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP" rel="stylesheet">
    <style>
        body {
            background: #f3f3f3;
        }
    </style>
    <title>写真を投稿する</title>
</head>
<body>
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
                        <li class="nav-item active">
                            <a class="nav-link" href="/post">投稿</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-6 col-xs-12 offset-md-3">
        <form method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
            <div class="form-group">
                <div class="col-12">
                    <div class="input-group">
                        <label class="input-group-btn" for="File">
                            <span class="btn btn-outline-primary btn-block mb-4">
                                画像を選択
                                <input type="file" name="file" size="30" style="display: none" class="form-control-file" id="File">
                            </span>
                        </label>
                        <input type="text" class="form-control" readonly="">
                    </div>
                    <textarea name="caption" class="form-control mb-4" placeholder="投稿のキャプション"></textarea>
                    <button type="submit" class="btn btn-primary">投稿</button>
                </div>
            </div>
            <input type="hidden" name="where" value='from_html'>
        </form>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    $(document).on('change', ':file', function() {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.parent().parent().next(':text').val(label);
    });
</script>
</body>
</html>