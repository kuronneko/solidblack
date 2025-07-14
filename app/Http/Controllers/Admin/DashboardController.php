<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use Inertia\Inertia;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Dashboard');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Clear unposted blogs.
     *
     * @return \Illuminate\Http\Response
     */
    public function clearBlogs()
    {
        try {
            $blogs = Blog::where('status', 0)->get();

            foreach ($blogs as $blog) {
                if (config('filesystems.default')  == 's3') {
                    $folderPath = env('AWS_UPLOAD_FOLDER') . '/' . $blog->id;
                    if (Storage::disk('s3')->exists($folderPath)) {
                        Storage::disk('s3')->deleteDirectory($folderPath);
                    }
                } else {
                    $folderPath = 'public/blog/' . $blog->id;
                    if (Storage::exists($folderPath)) {
                        Storage::deleteDirectory($folderPath);
                    }
                }

                $blog->delete();
            }

            $blogs->each->delete();

            return redirect()->back();
            //return redirect()->back()->with('message', 'Unposted Blogs Cleared');
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    /**
     * Get the count of unposted blogs.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUnpostedBlogs()
    {
        try {
            $blogs = Blog::where('status', 0)->get();

            $count = $blogs->count();

            return response()->json(['count' => $count]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    /**
     * Get the status of the setting.
     *
     * @return \Illuminate\Http\Response
     */
    public function getStatus()
    {
        try {
            return response()->json(['status' => Setting::first()->status]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    /**
     * Update the status of the setting.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateStatus()
    {
        try {
            $setting = Setting::first();
            $setting->status = request('status');
            $setting->update();

            return redirect()->back();
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }
}
