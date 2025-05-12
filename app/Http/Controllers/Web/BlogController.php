<?php

namespace App\Http\Controllers\Web;

use App\Models\Blog;
use Inertia\Inertia;
use App\Models\Setting;
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
    public function getAllBlogs(Request $request)
    {
        $query = Blog::with(['user', 'categories']);

        if (Auth::user()) {

            if ($request->category) {
                $query->whereHas('categories', function ($q) use ($request) {
                    $q->where('slug', $request->category);
                });
            }

            $query->whereIn('status', [1, 2]);

        } else {

            $query->where(function ($q) {
                $q->whereDoesntHave('categories')
                    ->orWhereHas('categories', function ($query) {
                        $query->where('slug', config('app.default_category'));
                    });
            });

            $query->where('status', 2);
        }

        return response()->json([
            'blogs' => $query->orderBy('created_at', 'desc')
                ->skip(request('skip'))
                ->take(request('take'))
                ->get()
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
        $query = Blog::with(['user', 'categories']);

        if (Auth::user()) {
            $query->whereIn('status', [1, 2]);
        } else {
            $query->where('status', 2);
        }

        $blog = $query->where('slug', $slug)->first();

        $setting = Setting::first();

        if (!$blog) {
            abort(404);
        } else {
            return Inertia::render('Blog', compact('blog', 'setting'));
        }
    }
}
