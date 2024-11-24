@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>出退勤登録</h2>

        <form action="{{ route('attendances.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="user_id">ユーザーID:</label>
                <input type="text" class="form-control" id="user_id" name="user_id" value="{{ old('user_id') }}" required>
                @error('user_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="start_time">出勤時間:</label>
                <input type="datetime-local" class="form-control" id="start_time" name="start_time" value="{{ old('start_time') }}" required>
                @error('start_time')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="end_time">退勤時間:</label>
                <input type="datetime-local" class="form-control" id="end_time" name="end_time" value="{{ old('end_time') }}">
                @error('end_time')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            
            <div class="form-group" id="breaks">
                <label for="breaks">休憩時間:</label>
                <div class="break">
                    <input type="datetime-local" class="form-control" name="breaks[0][break_start]" placeholder="休憩開始" required>
                    <input type="datetime-local" class="form-control" name="breaks[0][break_end]" placeholder="休憩終了" required>
                </div>
                
            </div>

            <button type="button" class="btn btn-secondary" id="add-break">休憩時間を追加</button>

            <button type="submit" class="btn btn-primary">保存</button>
        </form>
    </div>

    <script>
        document.getElementById('add-break').addEventListener('click', function() {
            let breaksContainer = document.getElementById('breaks');
            let breakCount = breaksContainer.querySelectorAll('.break').length;
            
            let newBreak = document.createElement('div');
            newBreak.classList.add('break');
            newBreak.innerHTML = `
                <input type="datetime-local" class="form-control" name="breaks[${breakCount}][break_start]" placeholder="休憩開始" required>
                <input type="datetime-local" class="form-control" name="breaks[${breakCount}][break_end]" placeholder="休憩終了" required>
            `;
            
            breaksContainer.appendChild(newBreak);
        });
    </script>
@endsection
