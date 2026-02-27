<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_attempt_id',
        'question_id',
        'answer',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'quiz_attempt_id' => 'integer',
        'question_id' => 'integer',
        'answer' => 'integer',
    ];

    /**
     * Get the user that owns the quiz result.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the question that the quiz result belongs to.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Get the quiz attempt that the quiz result belongs to.
     */
    public function quizAttempt()
    {
        return $this->belongsTo(QuizAttempt::class, 'quiz_attempt_id');
    }
}
