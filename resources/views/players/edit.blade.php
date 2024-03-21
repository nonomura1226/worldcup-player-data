<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>選手編集画面</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1>■選手データ</h1>
    <form action="{{ route('players.update', $player->id) }}" method="POST">
        @csrf
        @method('PUT')
        <table class="table table-striped table-bordered border-white">
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">{{ $player->id }}</th>
                <input type="hidden" name="id" value="{{ $player->id }}">
            </tr>
            <tr>
                <th class="text-center">背番号</th>
                <th class="text-left px-5">
                    @error('uniform_num')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <input type="text" name="uniform_num" value="{{ old('uniform_num', $player->uniform_num) }}" class="form-control">
                </th>
            </tr>
            <tr>
                <th class="text-center">ポジション</th>
                <th class="text-left px-5">
                    @error('position')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <select name="position" class="form-select" aria-label=".form-select-lg">
                        <option value="FW" {{ old('position', $player->position) == 'FW' ? 'selected' : '' }}>FW</option>
                        <option value="MF" {{ old('position', $player->position) == 'MF' ? 'selected' : '' }}>MF</option>
                        <option value="DF" {{ old('position', $player->position) == 'DF' ? 'selected' : '' }}>DF</option>
                        <option value="GK" {{ old('position', $player->position) == 'GK' ? 'selected' : '' }}>GK</option>
                    </select>
                </th>
            </tr>
            <tr>
                <th class="text-center">名前</th>
                <th class="text-left px-5">
                    @error('name')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <input type="text" name="name" value="{{ old('name', $player->name) }}" class="form-control">
                </th>
            </tr>
            <tr>
                <th class="text-center">国</th>
                <th class="text-left px-5">
                    @error('country_id')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <select name="country_id" class="form-select" aria-label=".form-select-lg">
                        @foreach($countryNames as $country)
                            <option value="{{ old('country_id', $country->id) }}" {{ $country->id == $player->country_id ? 'selected' : '' }}>{{ $country->name }}</option>
                        @endforeach
                    </select>
                </th>
            </tr>
            <tr>
                <th class="text-center">所属</th>
                <th class="text-left px-5">
                    @error('country_id')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <input type="text" name="club" value="{{ old('club', $player->club) }}" class="form-control">
                </th>
            </tr>
            <tr>
                <th class="text-center">誕生日</th>
                <th class="text-left px-5">
                    @error('birth')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <input type="date" name="birth" value="{{ old('birth', $player->birth) }}" class="form-control">
                </th>
            </tr>
            <tr>
                <th class="text-center">身長</th>
                <th class="text-left px-5">
                    @error('height')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <input type="text" name="height" value="{{ old('height', $player->height) }}" class="form-control">
                </th>
            </tr>
            <tr>
                <th class="text-center">体重</th>
                <th class="text-left px-5">
                    @error('weight')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <input type="text" name="weight" value="{{ old('weight', $player->weight) }}" class="form-control">
                </th>
            </tr>
        </table>
        <div class="d-flex justify-content-center mt-3">
            <button type="submit" class="btn" style="background-color: yellow; width: 80%; font-size: 20px;">編集</button>
        </div>
        <div class="d-flex justify-content-center mt-3">
            <a href="{{ route('players.index') }}" class="btn text-white" style="background-color: black; width: 80%; font-size: 20px;">戻る</a>
        </div>
    </form>
</body>
</html>