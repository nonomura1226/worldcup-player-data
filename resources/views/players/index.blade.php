<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>選手データ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <table class="table table-striped table-bordered border-white">
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">背番号</th>
            <th class="text-center">ポジション</th>
            <th class="text-center">所属</th>
            <th class="text-center">名前</th>
            <th class="text-center">誕生日</th>
            <th class="text-center">身長</th>
            <th class="text-center">体重</th>
            <th></th>
        </tr>
    @foreach($players as $player)
        <tr>
            <th class="text-center">{{ $player->id }}</th>
            <th class="text-center">{{ $player->uniform_num }}</th>
            <th class="text-center">{{ $player->position }}</th>
            <th class="text-center">{{ $player->club }}</th>
            <th class="text-center">{{ $player->name }}</th>
            <th class="text-center">{{ $player->birth }}</th>
            <th class="text-center">{{ $player->height }}</th>
            <th class="text-center">{{ $player->weight }}</th>
            <td class="text-center"><a href="{{ route('players.showDetail', ['id' => $player->id]) }}">詳細</a></td>
        </tr>
    @endforeach
    </table>
    <style>
        .pagination nav div div p{
            padding-top: 10px;
        }
        svg{
            max-width: 2%;
        }
    </style>
    <div class="pagination page-link">
    {{ $players->links() }}
    </div>    
</body>
</html>