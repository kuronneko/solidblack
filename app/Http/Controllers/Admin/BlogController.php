<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\BlogService;
use App\Services\ImageService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreBlogRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateBlogRequest;
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
        $blogs = Blog::where('user_id', Auth::user()->id)->whereIn('status', [0, 1, 2])->with(['user', 'categories'])->orderBy("created_at", 'desc');

        $search = "";
        if (request()->has("search")) {
            $search = request("search");
            $blogs = $blogs->where('name', 'like', '%' . $search . '%')->where('user_id', Auth::user()->id);
        }

        $blogs = $blogs->paginate(50)->appends(request()->except("page"));

        return Inertia::render('Blog/Index', compact('blogs', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $blog = Blog::create([
                'user_id' => Auth::user()->id,
                'name' => '',
                'content' => '',
                'slug' => '',
            ]);

            $categories = Category::where('status', 1)->get();

            return Inertia::render('Blog/Create', compact('blog', 'categories'));
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request) {}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        // Load both the categories and user relationships
        $blog->load(['categories', 'user']);

        return Inertia::render('Blog/Show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        $categories = Category::where('status', 1)->get();

        $blog->load('categories'); // Load the blog's categories

        return Inertia::render('Blog/Edit', compact('blog', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBlogRequest $request)
    {
        try {
            $blog = Blog::findOrFail(request('blog'));

            $blog->update([
                'name' => $request->name,
                'content' => $request->content,
                'slug' => Str::slug($request->name),
                'status' => $request->status,
                'published_at' => $request->date,
                'highlight' => $request->highlight,
                'metadata' => $request->metadata,
            ]);

            $blog->categories()->sync($request->categories);

            return redirect()->route('blog.index');
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        try {
            if (config('filesystems.default') == 's3') {

                $folderPath = config('filesystems.disks.s3.upload_folder') . '/' . $blog->id;

                if (Storage::disk('s3')->exists($folderPath)) {
                    Storage::disk('s3')->deleteDirectory($folderPath);
                }
            } else {

                $folderPath = 'public/blog/' . $blog->id;

                if (Storage::exists($folderPath)) {
                    Storage::deleteDirectory($folderPath);
                }
            }

            $blog->categories()->detach();

            $blog->delete();

            return redirect()->back();
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    /**
     * Upload an image to the server.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        return response()->json([
            'uploaded' => true,
            'url' => ImageService::uploadImagen($request->file('upload'), $request->blog)
        ]);
    }

    /**
     * Toggle the highlight status of the specified resource.
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
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
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
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
