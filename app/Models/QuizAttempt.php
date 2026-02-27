<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $table = 'quiz_attempts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'course_id',
        'category_id',
        'answers',
        'scores',
        'dominant_type',
        'total_score',
        'completed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'course_id' => 'integer',
            'category_id' => 'integer',
            'answers' => 'array',
            'scores' => 'array',
            'total_score' => 'integer',
            'completed_at' => 'datetime',
        ];
    }

    /**
     * Get the user that owns the quiz attempt.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the course that the quiz attempt belongs to.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the category that the quiz attempt belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the quiz results for the attempt.
     */
    public function quizResults()
    {
        return $this->hasMany(QuizResult::class);
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($quizAttempt) {
            // Delete all quiz results for this attempt (cascade)
            $quizAttempt->quizResults()->delete();
        });
    }
}
