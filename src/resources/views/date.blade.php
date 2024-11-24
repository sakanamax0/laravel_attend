<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>出退勤履歴</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header style="display: flex; justify-content: space-between; align-items: center; padding: 10px; background-color: #f3f3f3;">
        <h1 style="margin: 0;">Atte</h1>
        <nav>
            <a href="{{ route('carve') }}">ホーム</a> |
            <a href="{{ route('date.show', ['date' => $date]) }}">日付一覧</a> |
            <a href="{{ route('logout') }}">ログアウト</a>
        </nav>
    </header>

    <main style="display: flex; justify-content: center; flex-direction: column; align-items: center; min-height: 80vh;">
        <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 20px;">
            <a href="{{ route('date.change', ['direction' => 'previous', 'date' => $date]) }}" style="padding: 5px;">&lt;</a>
            <h2 style="margin: 0 20px;">{{ $date ?? '今日' }}</h2>
            <a href="{{ route('date.change', ['direction' => 'next', 'date' => $date]) }}" style="padding: 5px;">&gt;</a>
        </div>

        <table style="width: 80%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr style="background-color: #f3f3f3;">
                    <th style="padding: 10px; border: 1px solid #ddd;">名前</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">勤務開始</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">勤務終了</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">休憩時間</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">勤務時間</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($attendances as $attendanceItem)
                    <tr>
                        <td style="padding: 10px; border: 1px solid #ddd;">{{ $attendanceItem->user->name ?? '未登録' }}</td>
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            {{ optional($attendanceItem->start_time)->format('H:i') ?? '未開始' }}
                        </td>
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            {{ optional($attendanceItem->end_time)->format('H:i') ?? '未終了' }}
                        </td>
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            {{ $attendanceItem->total_break_time ?? 0 }} 分
                        </td>
                        <td style="padding: 10px; border: 1px solid #ddd;">
                            {{ $attendanceItem->work_hours ?? '未計算' }} 分
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 10px; border: 1px solid #ddd; text-align: center;">
                            データがありません
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            @if ($attendances->hasPages())
                <a href="{{ $attendances->previousPageUrl() }}" style="padding: 5px;">&lt;</a>

                @foreach ($attendances->getUrlRange(1, $attendances->lastPage()) as $page => $url)
                    <a href="{{ $url }}" style="padding: 5px; @if ($page == $attendances->currentPage()) font-weight: bold; @endif">
                        {{ $page }}
                    </a>
                @endforeach

                <a href="{{ $attendances->nextPageUrl() }}" style="padding: 5px;">&gt;</a>
            @endif
        </div>
        
    </main>

    <footer style="text-align: left; padding: 10px; background-color: #f3f3f3;">
        <p>Atte, inc.</p>
    </footer>

    
</body>
</html>