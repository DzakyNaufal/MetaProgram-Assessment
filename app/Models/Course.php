<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Course extends Model
{
    use HasFactory;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'questions_count',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'type',
        'kategori_meta_program_id',
        'description',
        'thumbnail',
        'estimated_time',
        'price',
        'is_active',
        'has_whatsapp_consultation',
        'has_offline_coaching',
        'order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected function casts(): array
    {
        return [
            'estimated_time' => 'integer',
            'price' => 'decimal:2',
            'is_active' => 'boolean',
            'has_whatsapp_consultation' => 'boolean',
            'has_offline_coaching' => 'boolean',
            'order' => 'integer',
        ];
    }

    /**
     * Get the categories for the course.
     */
    public function categories()
    {
        return $this->hasMany(Category::class)->orderBy('id');
    }

    /**
     * Get the kategori meta program for the course (for single kategori courses).
     */
    public function kategoriMetaProgram()
    {
        return $this->belongsTo(KategoriMetaProgram::class);
    }

    /**
     * Check if this is a single kategori course.
     */
    public function isSingleKategori(): bool
    {
        return !is_null($this->kategori_meta_program_id);
    }

    /**
     * Get the questions for the course (through categories).
     * Note: This returns 0 since the system uses PertanyaanMetaProgram.
     * Use getQuestionCount() method instead for actual count.
     */
    public function questions()
    {
        return $this->hasMany(Question::class)->orderBy('id');
    }

    /**
     * Get the actual question count using PertanyaanMetaProgram.
     */
    public function getQuestionCount(): int
    {
        if ($this->isSingleKategori()) {
            // Single kategori course - count questions for this kategori
            $kategori = $this->kategoriMetaProgram;
            if ($kategori) {
                $mpIds = \App\Models\MetaProgram::where('kategori_meta_program_id', $kategori->id)
                    ->where('is_active', true)
                    ->pluck('id');

                return \App\Models\PertanyaanMetaProgram::whereIn('meta_program_id', $mpIds)
                    ->where('is_active', true)
                    ->count();
            }
        } else {
            // Full assessment course - count all questions from all kategoris
            $allMpIds = \App\Models\MetaProgram::where('is_active', true)->pluck('id');
            return \App\Models\PertanyaanMetaProgram::whereIn('meta_program_id', $allMpIds)
                ->where('is_active', true)
                ->count();
        }

        return 0;
    }

    /**
     * Get the quiz attempts for the course.
     */
    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    /**
     * Get the purchases for the course.
     */
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    /**
     * Check if course is free.
     */
    public function isFree(): bool
    {
        return $this->price == 0;
    }

    /**
     * Get formatted price.
     */
    public function getFormattedPriceAttribute(): string
    {
        return $this->isFree() ? 'Gratis' : number_format($this->price, 0, ',', '.');
    }

    /**
     * Get the thumbnail URL.
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        if ($this->thumbnail) {
            return Storage::url($this->thumbnail);
        }
        return null;
    }

    /**
     * Get the questions count attribute.
     */
    public function getQuestionsCountAttribute(): int
    {
        return $this->getQuestionCount();
    }
}
