<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserKategoriProgress extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'course_id',
        'kategori_meta_program_id',
        'current_question_index',
        'total_questions',
        'is_completed',
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
            'kategori_meta_program_id' => 'integer',
            'current_question_index' => 'integer',
            'total_questions' => 'integer',
            'is_completed' => 'boolean',
            'completed_at' => 'datetime',
        ];
    }

    /**
     * Get the user that owns the progress.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the course that owns the progress.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the kategori meta program for the progress.
     */
    public function kategoriMetaProgram()
    {
        return $this->belongsTo(KategoriMetaProgram::class);
    }

    /**
     * Get the progress percentage.
     */
    public function getProgressPercentageAttribute()
    {
        if ($this->total_questions === 0) {
            return 0;
        }
        return min(100, ($this->current_question_index / $this->total_questions) * 100);
    }
}
