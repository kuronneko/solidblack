<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreBlogRequest;
use App\Services\BlogService;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::where('user_id', Auth::user()->id)->whereIn('status', [1, 2])->orderBy("created_at", 'desc');
        $search = "";
        if (request()->has("search")) {
            $search = request("search");
            $blogs = $blogs->where('name', 'like', '%' . $search . '%')->where('user_id', Auth::user()->id);
        }
        $blogs = $blogs->paginate(10)->appends(request()->except("page"));
        return Inertia::render('Blog/Index', compact('blogs', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $blog = Blog::create([
            'user_id' => Auth::user()->id,
            'name' => '',
            'content' => '',
            'slug' => '',
        ]);
        return Inertia::render('Blog/Create', compact('blog'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBlogRequest $request)
    {
        /*         Blog::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'content' => $request->content,
        ]);
        return redirect()->route('blog.index'); */
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        return Inertia::render('Blog/Show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        return Inertia::render('Blog/Edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreBlogRequest $request)
    {
        $blog = Blog::findOrFail(request('blog'));
        $blog->update([
            'name' => $request->name,
            'content' => $request->content,
            'slug' => Str::slug($request->name),
            'status' => $request->status,
            'published_at' => $request->date,
            'highlight' => $request->highlight,
        ]);
        return redirect()->route('blog.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        $folderPath = 'public/images/' . $blog->id;
        if (Storage::exists($folderPath)) {  //check if folder exist
            Storage::deleteDirectory($folderPath);
        }
        $blog->delete();
        return redirect()->back();
    }

    public function upload(Request $request)
    {
        // Get the uploaded file
        //$file = $request->file('upload');

        // Generate a unique file name
        //$fileName = uniqid() . '.' . $file->getClientOriginalExtension();

        // Save the file to your desired location
        // $file->storeAs('public/imagenes', $fileName);

        // Return the response in the format required by CKEditor

        return response()->json([
            'uploaded' => true,
            'url' => ImageService::uploadImagen($request->file('upload'), $request->blog)
            //'url' => asset('storage/imagenes/' . $fileName)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggleHighlight(Blog $blog)
    {
        try {
            if (auth()->user()->id == $blog->user_id) {
                if ($blog->highlight == 1) {
                    $blog->highlight = 0;
                } else {
                    $blog->highlight = 1;
                }
                $blog->timestamps = false;
                $blog->save();
                return redirect()->back();
            } else {
                return response()->json(['error' => 'Access deny']);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggleStatus(Blog $blog)
    {
        try {
            if (auth()->user()->id == $blog->user_id) {
                if ($blog->status == 2) {
                    $blog->status = 1;
                } else {
                    $blog->status = 2;
                }
                $blog->timestamps = false;
                $blog->save();
                return redirect()->back();
            } else {
                return response()->json(['error' => 'Access deny']);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllBlogs()
    {
        return response()->json([
            'blogs' => Blog::where('status', 2)->orderBy('published_at', 'desc')->skip(request('skip'))->take(request('take'))->get(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showWithSlug(Blog $blog, $slug)
    {
        //$blog = Blog::where('slug', request('slug'))->first();
        if (Str::slug($blog->slug, "-") != $slug) {
            abort(404);
        } else {
            return Inertia::render('Blog', compact('blog'));
        }
    }
}
