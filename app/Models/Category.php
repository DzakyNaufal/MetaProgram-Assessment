<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_id',
        'name',
        'slug',
        'description',
        'icon',
        'color',
        'order',
        'is_active',
        'price',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected function casts(): array
    {
        return [
            'course_id' => 'integer',
            'is_active' => 'boolean',
            'order' => 'integer',
            'price' => 'decimal:2',
        ];
    }

    /**
     * Get the course that owns the category.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the questions for the category.
     */
    public function questions()
    {
        return $this->hasMany(Question::class)->orderBy('id');
    }
}
