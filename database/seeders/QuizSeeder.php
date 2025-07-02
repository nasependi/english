<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil user pertama sebagai teacher (atau buat jika belum ada)
        $teacher = User::first();
        
        if (!$teacher) {
            $teacher = User::create([
                'name' => 'Teacher Demo',
                'email' => 'teacher@demo.com',
                'password' => bcrypt('password'),
            ]);
        }

        // Buat sample quiz
        $quiz = Quiz::create([
            'teacher_id' => $teacher->id,
            'title' => 'Basic English Grammar Quiz',
            'duration' => 15,
        ]);

        // Buat sample questions
        $questions = [
            [
                'question' => 'What is the past tense of "go"?',
                'type' => 'pg',
                'options' => [
                    'A' => 'goes',
                    'B' => 'went',
                    'C' => 'gone',
                    'D' => 'going'
                ],
                'answer_key' => 'B'
            ],
            [
                'question' => 'Choose the correct article: "I saw ___ elephant at the zoo."',
                'type' => 'pg',
                'options' => [
                    'A' => 'a',
                    'B' => 'an',
                    'C' => 'the',
                    'D' => 'no article needed'
                ],
                'answer_key' => 'B'
            ],
            [
                'question' => 'Which sentence is correct?',
                'type' => 'pg',
                'options' => [
                    'A' => 'She don\'t like coffee',
                    'B' => 'She doesn\'t likes coffee',
                    'C' => 'She doesn\'t like coffee',
                    'D' => 'She not like coffee'
                ],
                'answer_key' => 'C'
            ],
            [
                'question' => 'Write a short paragraph about your hobby. (Minimum 50 words)',
                'type' => 'essay',
                'options' => null,
                'answer_key' => 'Sample answer about hobby with proper grammar and vocabulary'
            ],
            [
                'question' => 'What is the plural form of "child"?',
                'type' => 'pg',
                'options' => [
                    'A' => 'childs',
                    'B' => 'childes',
                    'C' => 'children',
                    'D' => 'child'
                ],
                'answer_key' => 'C'
            ]
        ];

        foreach ($questions as $questionData) {
            Question::create([
                'quiz_id' => $quiz->id,
                'question' => $questionData['question'],
                'type' => $questionData['type'],
                'options' => $questionData['options'] ? json_encode($questionData['options']) : null,
                'answer_key' => $questionData['answer_key'],
            ]);
        }

        // Buat quiz kedua
        $quiz2 = Quiz::create([
            'teacher_id' => $teacher->id,
            'title' => 'English Vocabulary Test',
            'duration' => 10,
        ]);

        $questions2 = [
            [
                'question' => 'What does "enormous" mean?',
                'type' => 'pg',
                'options' => [
                    'A' => 'very small',
                    'B' => 'very large',
                    'C' => 'very fast',
                    'D' => 'very slow'
                ],
                'answer_key' => 'B'
            ],
            [
                'question' => 'Choose the synonym of "happy":',
                'type' => 'pg',
                'options' => [
                    'A' => 'sad',
                    'B' => 'angry',
                    'C' => 'joyful',
                    'D' => 'tired'
                ],
                'answer_key' => 'C'
            ],
            [
                'question' => 'Explain the difference between "accept" and "except" with examples.',
                'type' => 'essay',
                'options' => null,
                'answer_key' => 'Accept means to receive or agree to something. Except means excluding or apart from.'
            ]
        ];

        foreach ($questions2 as $questionData) {
            Question::create([
                'quiz_id' => $quiz2->id,
                'question' => $questionData['question'],
                'type' => $questionData['type'],
                'options' => $questionData['options'] ? json_encode($questionData['options']) : null,
                'answer_key' => $questionData['answer_key'],
            ]);
        }
    }
}
