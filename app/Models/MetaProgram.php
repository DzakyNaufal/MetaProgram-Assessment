<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetaProgram extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kategori_meta_program_id',
        'name',
        'slug',
        'description',
        'scoring_type',
        'order',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected function casts(): array
    {
        return [
            'kategori_meta_program_id' => 'integer',
            'order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the category that owns the meta program.
     */
    public function kategori()
    {
        return $this->belongsTo(KategoriMetaProgram::class, 'kategori_meta_program_id');
    }

    /**
     * Get the sub meta programs for the meta program.
     */
    public function subMetaPrograms()
    {
        return $this->hasMany(SubMetaProgram::class)->orderBy('id');
    }

    /**
     * Get the questions for the meta program.
     */
    public function pertanyaan()
    {
        return $this->hasMany(PertanyaanMetaProgram::class)->orderBy('id');
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($metaProgram) {
            // Delete all sub meta programs (cascade)
            $metaProgram->subMetaPrograms()->delete();

            // Delete all questions (cascade)
            $metaProgram->pertanyaan()->delete();
        });
    }
}
