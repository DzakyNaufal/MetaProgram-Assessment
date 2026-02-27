<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PertanyaanMetaProgram extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'meta_program_id',
        'sub_meta_program_id',
        'pertanyaan',
        'skala_sangat_setuju',
        'skala_setuju',
        'skala_agak_setuju',
        'skala_agak_tidak_setuju',
        'skala_tidak_setuju',
        'skala_sangat_tidak_setuju',
        'keterangan',
        'is_negatif',
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
            'sub_meta_program_id' => 'integer',
            'skala_sangat_setuju' => 'integer',
            'skala_setuju' => 'integer',
            'skala_agak_setuju' => 'integer',
            'skala_agak_tidak_setuju' => 'integer',
            'skala_tidak_setuju' => 'integer',
            'skala_sangat_tidak_setuju' => 'integer',
            'is_negatif' => 'boolean',
            'order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the meta program that owns the question.
     */
    public function metaProgram()
    {
        return $this->belongsTo(MetaProgram::class);
    }

    /**
     * Get the sub meta program that owns the question.
     */
    public function subMetaProgram()
    {
        return $this->belongsTo(SubMetaProgram::class);
    }
}
