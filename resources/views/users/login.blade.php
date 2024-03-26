<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン画面</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    {{-- 新規登録成功時メッセージ --}}
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    {{-- ログイン失敗時メッセージ --}}
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{ route('users.loginCheck') }}" method="POST">
        @csrf
        <div class="container mt-5" style="width: 40%;">
            <h3 class="my-3">ログイン</h3>
            <div class="mt-3">
                <h5>ログインID：</h5>
                @error('email')
                <div class="text-danger">{{ $message }}</div>
                @enderror
                <input type="text" name="email" class="form-control" placeholder="メールアドレス">
            </div>
            <div class="mt-3">
                <h5>パスワード：</h5>
                @error('password')
                <div class="text-danger">{{ $message }}</div>
                @enderror
                <input type="password" name="password" class="form-control" placeholder="パスワード">
            </div>
            <div class="d-flex justify-content-center mt-3">
                <button type="submit" class="btn" style="background-color: yellow; width: 100%; font-size: 20px;">ログイン</button>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <a href="{{ route('users.setting') }}">新規登録はこちら</a>
            </div>
        </div>
    </form>
</body>
</html>