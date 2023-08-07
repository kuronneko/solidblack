<?php

namespace App\Http\Controllers\Web;

use App\Models\Blog;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\BlogService;
use App\Services\ImageService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreBlogRequest;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllBlogs()
    {
        return response()->json([
            'blogs' => Blog::where('status', 2)->orderBy('created_at', 'desc')->skip(request('skip'))->take(request('take'))->get(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showWithSlug($slug)
    {
        $blog = Blog::where('slug', $slug)->first();
        if (!$blog) {
            abort(404);
        } else {
            return Inertia::render('Blog', compact('blog'));
        }
    }
}
