<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriMetaProgram extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'order',
        'is_active',
        'timer_duration',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected function casts(): array
    {
        return [
            'order' => 'integer',
            'is_active' => 'boolean',
            'timer_duration' => 'integer',
        ];
    }

    /**
     * Get the meta programs for the category.
     */
    public function metaPrograms()
    {
        return $this->hasMany(MetaProgram::class, 'kategori_meta_program_id')->orderBy('id');
    }

    /**
     * Get the user progress for this kategori.
     */
    public function kategoriProgresses()
    {
        return $this->hasMany(UserKategoriProgress::class, 'kategori_meta_program_id');
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($kategori) {
            // Delete all meta programs in this category (cascade)
            foreach ($kategori->metaPrograms as $metaProgram) {
                // This will trigger the MetaProgram deleting event which handles
                // deletion of sub meta programs and questions
                $metaProgram->delete();
            }

            // Delete user progresses for this kategori
            $kategori->kategoriProgresses()->delete();
        });
    }
}
