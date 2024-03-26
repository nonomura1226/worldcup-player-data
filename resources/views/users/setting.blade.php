<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録画面</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <form id="registerForm" action="{{ route('users.setting') }}" method="POST">
        @csrf
        <div class="container mt-5" style="width: 40%;">
            <h3 class="my-3">新規登録画面</h3>
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
            <div class="mt-3">
                <h5>パスワード確認：</h5>
                @error('password_confirmation')
                <div class="text-danger">{{ $message }}</div>
                @enderror
                <input type="password" name="password_confirmation" class="form-control" placeholder="パスワード確認">
            </div>
            <div class="mt-3">
                <h5>ユーザー種別：</h5>
                @error('role')
                <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="d-flex">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="role" id="general" value="0" checked>
                        <label class="form-check-label" for="general">一般ユーザー</label>
                    </div>
                    {{-- 間隔があかないので調整 --}}
                    <div class="mx-2"></div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="role" id="admin" value="1">
                        <label class="form-check-label" for="admin">管理ユーザー</label>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <h5>所属国選択：</h5>
                @error('country_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror
                <select id="countrySelect" name="country_select" class="form-select">
                    @foreach($countryNames as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
                {{-- 管理ユーザーに対応するため、hiddenで値保持 --}}
                <input type="hidden" name="country_id" id="countryId" value="0">
            </div>
            <div class="d-flex justify-content-center mt-3">
                <button id="registerButton" type="button" class="btn" style="background-color: yellow; width: 100%; font-size: 20px;">登録</button>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <a href="{{ route('users.login') }}" class="btn text-white" style="background-color: black; width: 100%; font-size: 20px;">ログイン画面に戻る</a>
            </div>
        </div>
    </form>

    <script>
        // 所属国選択セレクトボックスの変更時にhiddenに値を設定
        document.getElementById('countrySelect').addEventListener('change', function () {
            const selectedCountryId = this.value;
            document.getElementById('countryId').value = selectedCountryId;
        });

        document.addEventListener('DOMContentLoaded', function () {
            const roleRadios = document.querySelectorAll('input[name="role"]');
            const countrySelect = document.getElementById('countrySelect');
            const countryId = document.getElementById('countryId');
            const registerButton = document.getElementById('registerButton');
            const registerForm = document.getElementById('registerForm');

            // ユーザー選択時の所属国選択操作
            roleRadios.forEach(radio => {
                radio.addEventListener('change', function () {
                    // 管理ユーザー:1,一般ユーザー:0
                    if (this.value === '1') {
                        // 選択肢を選択不可に設定
                        countrySelect.disabled = true;
                        // 管理ユーザーが選択された場合、hiddenのcountry_idを0に設定
                        countryId.value = '0';
                    } else {
                        // 選択肢を選択可能にする
                        countrySelect.disabled = false;
                    }
                });
            });

            // 登録ボタンクリック時の処理
            registerButton.addEventListener('click', function () {
                const confirmed = confirm('この情報でユーザー登録を行いますか？');
                if (confirmed) {
                    registerForm.submit();
                }
            });
        });
    </script>
</body>
</html>