<?php

namespace App\Http\Middleware;

use App\Models\Course;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCourseAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ambil course dari route parameter
        $course = $request->route('course');

        if (!$course) {
            return $next($request);
        }

        // Cek jika $course adalah slug, bukan object Course
        if (is_string($course)) {
            $course = Course::where('slug', $course)->firstOrFail();
        }

        // Cek apakah user bisa akses course
        if (!$request->user()->canAccessCourse($course)) {
            return redirect()->route('pricing')
                ->with('info', 'Anda perlu upgrade paket untuk mengakses course ini.');
        }

        return $next($request);
    }
}
