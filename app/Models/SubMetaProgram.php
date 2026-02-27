<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMetaProgram extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'meta_program_id',
        'name',
        'slug',
        'description',
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
            'meta_program_id' => 'integer',
            'order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the meta program that owns the sub meta program.
     */
    public function metaProgram()
    {
        return $this->belongsTo(MetaProgram::class);
    }

    /**
     * Get the questions for the sub meta program.
     */
    public function pertanyaan()
    {
        return $this->hasMany(PertanyaanMetaProgram::class)->orderBy('id');
    }
}
