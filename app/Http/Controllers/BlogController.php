<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use illuminate\Validation\Rule;
use Carbon\Carbon;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::all();
        return response()->json($blogs);
    }

    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        return response()->json($blog);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|string|max:255',
            'views' => 'integer',
        ]);

        $validatedData['created_at'] = Carbon::now();
        $validatedData['updated_at'] = Carbon::now();

        $blog = Blog::create($validatedData);

        return response()->json(['success' => 'Blog created successfully'], 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|string|max:255',
            'views' => 'integer',
        ]);

        $validatedData['updated_at'] = Carbon::now();

        $blog = Blog::findOrFail($id);
        $blog->update($validatedData);

        return response()->json(['success' => 'Blog updated successfully'], 200);
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return response()->json(['message' => 'Blog deleted successfully']);
    }
}