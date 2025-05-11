<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $latest_blogs = Blog::where('published',true)->latest()->take(5)->get();

        // Get the IDs of the latest 5 blogs
        $excluded_ids = $latest_blogs->pluck('id');

        // Fetch the rest, excluding the latest 5
        $blogs = Blog::where('published', true)
                     ->whereNotIn('id', $excluded_ids) // Exclude the latest 5 blogs
                     ->latest()
                     ->paginate(10);


        return view('blog.index', [
            'blogs' => $blogs,
            'latest_blogs' => $latest_blogs
        ]);
    }

    public function show(Blog $blog)
    {
        if(!$blog->published) abort(404);

        return view('blog.show', compact('blog'));
    }

    public function preview(Blog $blog)
    {
        if(!hasAbility('blog.preview') || $blog->published) abort(404,'Your blog has already been published.');

        return view('blog.show',compact('blog'));

    }
}
