<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Blog;

class BlogController extends Controller
{
    //

    public function index()
    {

        return Inertia::render('Blog', [
            'blogs' => Blog::all(),
        ]   
        );
    }

    public function create()
    {
        return Inertia::render('CreateBlog');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $blog = new Blog();
        $blog->title = $request->title;
        $blog->content = $request->content;
        $blog->save();

        return redirect()->route('blogs.index');
    }

    public function edit($id)
    {
        $blog = Blog::find($id);
        return Inertia::render('EditBlog', [
            'blog' => $blog,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $blog = Blog::find($id);
        $blog->title = $request->title;
        $blog->content = $request->content;
        $blog->save();

        return redirect()->route('blogs.index');
    }

    public function destroy($id)
    {
        $blog = Blog::find($id);
        $blog->delete();

        return redirect()->route('blogs.index');
    }

    public function show($id)
    {
        $blog = Blog::find($id);
        return Inertia::render('ShowBlog', [
            'blog' => $blog,
        ]);
    }
}
