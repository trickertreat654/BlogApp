<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Blog;
use Illuminate\Support\Facades\Storage;
use App\Models\Picture;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Log;

class BlogController extends Controller
{
    //

    public function index()
    {

        $user = auth()->user();
       
        return Inertia::render('Blog', [
            'blogs' => $user->blogs            
        ]   
        );
    }

    public function create()
    {
        $pictures = auth()->user()->pictures;
        $url = Storage::temporaryUrl(
            'TheHero.png', now()->addMinutes(5)
        );
        return Inertia::render('CreateBlog',[
            'pictures' => $pictures,
            'url' => $url
        ]);        
    
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
        $blog->user_id = auth()->user()->id;
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
        // if ($blog->user_id !== auth()->user()->id) {
        //     return redirect()->route('blogs.index');
        // }
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

    public function storePicture(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image',
        ]);
        Log::info($request);
        $file = $request->file('avatar');
        Log::info($file);
        // $avatar = $request->file('avatar')->store('avatars');
        // Log::info($avatar);
        Log::info('bobo');
    
        // The 's3' disk corresponds to the 's3' configuration in filesystems.php.
        // 'public' visibility will make the file publicly accessible. If you want the file to be private, you can omit the third argument.
         $path = Storage::disk('s3')->putFile('pictures', new File($file), 'private');
        // $path = $request->file('avatar')->store('avatars', 's3');


         Log::info($path);
    
        // Retrieve the full URL to the file on S3

        $url = Storage::disk('s3')->temporaryUrl($path, now()->addMinutes(5));

        $user = auth()->user();
    
        // Store the URL to your Picture model (or any other relevant model you have)
        $picture = new Picture();
        $picture->path = $url; // Save the S3 URL instead of the path
        $picture->user_id = $user->id; // Assuming you want to associate it with the currently authenticated user
        $picture->save();
    
        return redirect()->route('blogs.create')->with('status', 'Picture uploaded successfully!');
    }

    // public function storePicture(Request $request)
    // {

    //     Log::info($request);
    //     $request->validate([
    //         'avatar' => 'required|image',
    //     ]);

    //     // $path = $request->file('picture')->store('pictures');
        
      
    //     $temp = $request->file('avatar');
    //     Log::info($temp);
    //     // $path = Storage::putFile('photos', new File($request->file('picture')));
    //     $path = Storage::disk('s3')->putFile('photos', $request->file('avatar'), 'public');
        
    //     Log::info($path);
    //     $picture = new Picture();
    //     Log::info($picture);
    //     $picture->path = $path;
    //     $picture->user_id = auth()->user()->id;
    //     $picture->save();

    //     return redirect()->route('blogs.create');
    // }
}
