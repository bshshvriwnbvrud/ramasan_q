<?php

namespace App\Imports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\Importable;

class QuestionsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
    use Importable, SkipsErrors;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Question([
            'text'           => $row['text'],
            'choice_a'       => $row['choice_a'],
            'choice_b'       => $row['choice_b'],
            'choice_c'       => $row['choice_c'],
            'choice_d'       => $row['choice_d'],
            'correct_choice' => strtoupper($row['correct_choice']),
            'time_sec'       => isset($row['time_sec']) ? (int) $row['time_sec'] : null,
        ]);
    }

    /**
     * قواعد التحقق من الصحة لكل صف
     */
    public function rules(): array
    {
        return [
            'text'           => 'required|string',
            'choice_a'       => 'required|string',
            'choice_b'       => 'required|string',
            'choice_c'       => 'required|string',
            'choice_d'       => 'required|string',
            'correct_choice' => 'required|in:A,B,C,D',
            'time_sec'       => 'nullable|integer|min:5',
        ];
    }

    /**
     * رسائل الخطأ المخصصة (اختياري)
     */
    public function customValidationMessages()
    {
        return [
            'correct_choice.in' => 'الإجابة الصحيحة يجب أن تكون A, B, C, أو D',
        ];
    }
}