<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::orderBy('id')->get();

        // Calculate question count for each course
        foreach ($courses as $course) {
            if ($course->isSingleKategori()) {
                // Single kategori course - count questions for this kategori
                $kategori = $course->kategoriMetaProgram;
                if ($kategori) {
                    $mpIds = \App\Models\MetaProgram::where('kategori_meta_program_id', $kategori->id)
                        ->where('is_active', true)
                        ->pluck('id');

                    $questionCount = \App\Models\PertanyaanMetaProgram::whereIn('meta_program_id', $mpIds)
                        ->where('is_active', true)
                        ->count();

                    // Add dynamic attribute
                    $course->questions_count = $questionCount;
                }
            } else {
                // Full assessment course - count all questions from all kategoris
                $allMpIds = \App\Models\MetaProgram::where('is_active', true)->pluck('id');
                $questionCount = \App\Models\PertanyaanMetaProgram::whereIn('meta_program_id', $allMpIds)
                    ->where('is_active', true)
                    ->count();

                $course->questions_count = $questionCount;
            }
        }

        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|alpha_dash|max:255|unique:courses',
            'type' => 'required|in:basic,premium,elite',
            'kategori_meta_program_id' => 'nullable|exists:kategori_meta_programs,id',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'estimated_time' => 'nullable|integer|min:1',
            'price' => 'required|numeric|min:0',
            'is_active' => 'boolean',
            'has_whatsapp_consultation' => 'boolean',
            'has_offline_coaching' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('courses', 'public');
        }

        Course::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'type' => $request->type,
            'kategori_meta_program_id' => $request->kategori_meta_program_id,
            'description' => $request->description,
            'thumbnail' => $thumbnailPath,
            'estimated_time' => $request->estimated_time,
            'price' => $request->price,
            'is_active' => $request->has('is_active'),
            'has_whatsapp_consultation' => $request->has('has_whatsapp_consultation'),
            'has_offline_coaching' => $request->has('has_offline_coaching'),
            'order' => $request->order ?? 0,
        ]);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $course->load('questions');
        return view('admin.courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'alpha_dash',
                'max:255',
                Rule::unique('courses')->ignore($course->id)
            ],
            'type' => 'required|in:basic,premium,elite',
            'kategori_meta_program_id' => 'nullable|exists:kategori_meta_programs,id',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'estimated_time' => 'nullable|integer|min:1',
            'price' => 'required|numeric|min:0',
            'is_active' => 'boolean',
            'has_whatsapp_consultation' => 'boolean',
            'has_offline_coaching' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        // Handle thumbnail upload
        $thumbnailPath = $course->thumbnail; // Keep existing if no new file
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($course->thumbnail && Storage::disk('public')->exists($course->thumbnail)) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            $thumbnailPath = $request->file('thumbnail')->store('courses', 'public');
        }

        $course->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'type' => $request->type,
            'kategori_meta_program_id' => $request->kategori_meta_program_id,
            'description' => $request->description,
            'thumbnail' => $thumbnailPath,
            'estimated_time' => $request->estimated_time,
            'price' => $request->price,
            'is_active' => $request->has('is_active'),
            'has_whatsapp_consultation' => $request->has('has_whatsapp_consultation'),
            'has_offline_coaching' => $request->has('has_offline_coaching'),
            'order' => $request->order ?? $course->order,
        ]);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        // Delete thumbnail if exists
        if ($course->thumbnail && Storage::disk('public')->exists($course->thumbnail)) {
            Storage::disk('public')->delete($course->thumbnail);
        }

        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course berhasil dihapus.');
    }
}
