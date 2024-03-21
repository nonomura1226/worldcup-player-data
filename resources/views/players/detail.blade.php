<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>選手詳細</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1>■選手データ</h1>
    <table class="table table-striped table-bordered border-white">
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">{{ $player->id }}</th>
        </tr>
        <tr>
            <th class="text-center">背番号</th>
            <th class="text-center">{{ $player->uniform_num }}</th>
        </tr>
        <tr>
            <th class="text-center">ポジション</th>
            <th class="text-center">{{ $player->position }}</th>
        </tr>
        <tr>
            <th class="text-center">名前</th>
            <th class="text-center">{{ $player->name }}</th>
        </tr>
        <tr>
            <th class="text-center">国</th>
            <th class="text-center">{{ $player->country->name }}</th>
        </tr>
        <tr>
            <th class="text-center">所属</th>
            <th class="text-center">{{ $player->club }}</th>
        </tr>
        <tr>
            <th class="text-center">誕生日</th>
            <th class="text-center">{{ $player->birth }}</th>
        </tr>
        <tr>
            <th class="text-center">身長</th>
            <th class="text-center">{{ $player->height }}</th>
        </tr>
        <tr>
            <th class="text-center">体重</th>
            <th class="text-center">{{ $player->weight }}</th>
        </tr>
        <tr>
            <th class="text-center">総得点</th>
            <th class="text-center">{{ $goalsCount }}</th>
        </tr>
        <tr>
            <th class="text-center">得点履歴</th>
            @if(!is_null($player->pairings))
                <th class="text-center">
                @foreach($player->pairings as $index => $pairing)
                    ・{{ $pairing->kickoff }}開始 {{$pairing->enemyCountry->name}}戦 {{ $player->goals->first()->goal_time}}: {{ $index + 1 }}点目<br>
                @endforeach
                </th>
            @else
                <th></th>
            @endif
        </tr>
    </table>
    <div class="d-flex justify-content-center mt-3">
        <a href="{{ route('players.index') }}" class="btn btn-primary text-white" style="background-color: black; border: none; width: 80%; font-size: 20px;">戻る</a>
    </div>
</body>
</html>