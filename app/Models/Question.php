<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'course_id',
        'meta_program_id',
        'question_text',
        'order',
        'is_active',
        'is_reverse',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected function casts(): array
    {
        return [
            'category_id' => 'integer',
            'course_id' => 'integer',
            'meta_program_id' => 'integer',
            'order' => 'integer',
            'is_active' => 'boolean',
            'is_reverse' => 'boolean',
        ];
    }

    /**
     * Get the category that owns the question.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the course that owns the question.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the meta program that owns the question.
     */
    public function metaProgram()
    {
        return $this->belongsTo(MetaProgram::class);
    }

    /**
     * Get the options for the question.
     */
    public function options()
    {
        return $this->hasMany(QuestionOption::class)->orderBy('id');
    }
}
