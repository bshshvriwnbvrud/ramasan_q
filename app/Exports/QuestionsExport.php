<?php

namespace App\Exports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class QuestionsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Question::all();
    }

    /**
     * رؤوس الأعمدة في ملف Excel
     */
    public function headings(): array
    {
        return [
            'text',
            'choice_a',
            'choice_b',
            'choice_c',
            'choice_d',
            'correct_choice',
            'time_sec',
        ];
    }

    /**
     * تنسيق البيانات قبل التصدير
     */
    public function map($question): array
    {
        return [
            $question->text,
            $question->choice_a,
            $question->choice_b,
            $question->choice_c,
            $question->choice_d,
            $question->correct_choice,
            $question->time_sec,
        ];
    }
}