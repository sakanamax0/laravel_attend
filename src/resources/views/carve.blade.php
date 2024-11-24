<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>勤怠システム</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        button {
            padding: 10px;
            border: none;
            border-radius: 4px;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .start-work { background-color: #4caf50; }
        .end-work { background-color: #f44336; }
        .start-break { background-color: #4CAF50; }
        .end-break { background-color: #2196f3; }
        .disabled {
            background-color: gray;
            color: white;
            border: none;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    @php
        $date = $date ?? \Carbon\Carbon::now()->toDateString();
        $userName = $userName ?? 'ゲスト'; 
    @endphp

    
    <header style="display: flex; justify-content: space-between; align-items: center; padding: 10px; background-color: #f3f3f3;">
        <h1 style="margin: 0;">Atte</h1>
        <nav>
            <a href="{{ route('carve') }}">ホーム</a>
            <a href="{{ route('date.show', ['date' => $date]) }}">日付一覧</a>
            <a href="{{ route('logout') }}">ログアウト</a>
        </nav>
    </header>

    <main style="display: flex; justify-content: center; align-items: center; min-height: 80vh;">
        <div style="text-align: center;">
            <h2>{{ $userName }}さんお疲れ様です！</h2>
            <p>現在の日付: {{ $date ?? '今日' }}</p>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">
                
                <form action="{{ route('start.work') }}" method="POST">
                    @csrf
                    <button type="submit" 
                        class="start-work {{ $isWorking ? 'disabled' : '' }}" 
                        {{ $isWorking ? 'disabled' : '' }}>
                        勤務開始
                    </button>
                </form>

                
                <form action="{{ route('end.work') }}" method="POST">
                    @csrf
                    <button type="submit" 
                        class="end-work {{ !$isWorking ? 'disabled' : '' }}" 
                        {{ !$isWorking ? 'disabled' : '' }}>
                        勤務終了
                    </button>
                </form>

                
                <form action="{{ route('start.break') }}" method="POST">
                    @csrf
                    <input type="hidden" name="attendance_id" value="{{ $attendance->id ?? '' }}">
                    <button type="submit" 
                        class="break_start {{ $isOnBreak ? 'disabled' : '' }}" 
                        {{ $isOnBreak ? 'disabled' : '' }}
                        {{ !$isWorking ? 'disabled' : '' }}>
                        休憩開始
                    </button>
                </form>

                
                <form action="{{ route('end.break') }}" method="POST">
                    @csrf
                    <input type="hidden" name="attendance_id" value="{{ $attendance->id ?? '' }}">
                    <button type="submit" 
                        class="end-break {{ !$isOnBreak ? 'disabled' : '' }}" 
                        {{ !$isOnBreak ? 'disabled' : '' }}
                        {{ !$isWorking ? 'disabled' : '' }}>
                        休憩終了
                    </button>
                </form>
            </div>
        </div>
    </main>

    <footer style="text-align: left; padding: 10px; background-color: #f3f3f3;">
        <p>Atte, inc.</p>
    </footer>
</body>
</html>
