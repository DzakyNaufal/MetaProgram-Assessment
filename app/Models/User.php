<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the purchases for the user.
     */
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    /**
     * Get the active purchases for the user.
     */
    public function activePurchases()
    {
        return $this->hasMany(Purchase::class)->active();
    }

    /**
     * Get the quiz attempts for the user.
     */
    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    /**
     * Cek apakah user punya purchase active untuk course tertentu
     */
    public function hasActivePurchaseForCourse(int $courseId): bool
    {
        return $this->activePurchases()->where('course_id', $courseId)->exists();
    }

    /**
     * Cek apakah user bisa akses course tertentu
     * Free course (price = 0) - semua user login bisa akses
     * Paid course - cek apakah user punya purchase active untuk course tersebut
     */
    public function canAccessCourse(Course $course): bool
    {
        // Free course
        if ($course->isFree()) {
            return true;
        }

        // Cek apakah user punya purchase active untuk course tersebut
        return $this->hasActivePurchaseForCourse($course->id);
    }

    /**
     * Cek apakah user adalah admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
