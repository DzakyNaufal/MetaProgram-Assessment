<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with(['courses' => function ($query) {
            $query->where('is_active', true);
        }]) // Load courses to check for paid content
            ->where('is_active', true)
            ->orderBy('id')
            ->get();

        return view('categories.index', compact('categories'));
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $courses = $category->courses()
            ->where('is_active', true)
            ->orderBy('title')
            ->get();

        return view('categories.show', compact('category', 'courses'));
    }
}
