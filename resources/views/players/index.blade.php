<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>選手一覧</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    {{-- 編集、削除成功時メッセージ --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    {{-- 編集、削除失敗時メッセージ --}}
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <h1>■選手データ</h1>
    <table class="table table-striped table-bordered border-white">
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">背番号</th>
            <th class="text-center">ポジション</th>
            <th class="text-center">所属</th>
            <th class="text-center">名前</th>
            <th class="text-center">国</th>
            <th class="text-center">誕生日</th>
            <th class="text-center">身長</th>
            <th class="text-center">体重</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    @foreach($players as $player)
        <tr>
            <th class="text-center">{{ $player->id }}</th>
            <th class="text-center">{{ $player->uniform_num }}</th>
            <th class="text-center">{{ $player->position }}</th>
            <th class="text-center">{{ $player->club }}</th>
            <th class="text-center">{{ $player->name }}</th>
            <th class="text-center">{{ $player->country->name }}</th>
            <th class="text-center">{{ $player->birth }}</th>
            <th class="text-center">{{ $player->height }}</th>
            <th class="text-center">{{ $player->weight }}</th>
            <td class="text-center">
                <button type="button" class="btn btn-info text-white" onclick="window.location.href='{{ route('players.showDetail', ['id' => $player->id]) }}'">詳細</button>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-success text-white" onclick="window.location.href='{{ route('players.edit', ['id' => $player->id]) }}'">編集</button>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger text-white" data-bs-toggle="modal" data-bs-target="#deleteDialog{{ $player->id }}">削除</button>
            </td>
            <div class="modal fade" id="deleteDialog{{ $player->id }}" tabindex="-1" aria-labelledby="deleteDialogLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteDialogLabel">削除確認</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>この選手データを削除しますか？</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger execDelete" data-id="{{ $player->id }}">削除</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <script>
                // 削除ボタンがクリックされた場合
                document.querySelectorAll('.execDelete').forEach(button => {
                    button.addEventListener('click', function () {
                        let playerId = this.getAttribute('data-id');
                        window.location.href = `/players/${playerId}/delete`;
                    });
                });
            </script>
        </tr>
    @endforeach
    </table>
    <style>
        .pagination nav div div p {
            padding-top: 10px;
        }
        svg {
            max-width: 2%;
        }
        .modal-open .modal-backdrop {
            background-color: transparent;
        }
    </style>
    <div class="pagination page-link">
    {{ $players->links() }}
    </div>
</table>
</body>
</html>