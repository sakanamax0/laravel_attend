<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StartWorkRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'start_time' => 'required|date_format:H:i:s',
        ];
    }

    public function messages()
    {
        return [
            'start_time.required' => '勤務開始時間は必須です。',
            'start_time.date_format' => '時間形式が正しくありません。',
        ];
    }
}
