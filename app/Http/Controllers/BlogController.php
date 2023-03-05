<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    public function index()
    {
        $blogs = Blog::where('user_id', Auth::user()->id)->whereIn('status', [1,2])->orderBy("created_at", 'desc');
        $search = "";
        if (request()->has("search")) {
            $search = request("search");
            $blogs = $blogs->where('name', 'like', '%' . $search . '%')->where('user_id', Auth::user()->id);
        }
        $blogs = $blogs->paginate(10)->appends(request()->except("page"));
        return Inertia::render('Blog/Index', compact('blogs', 'search'));
    }

    public function getAllBlogs(){
        return response()->json([
            'blogs' => Blog::where('status', 2)->orderBy('published_at', 'desc')->skip(request('skip'))->take(request('take'))->get(),
        ]);
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
            'url' => self::uploadImagen($request->file('upload'), $request->blog)
            //'url' => asset('storage/imagenes/' . $fileName)
        ]);
    }

    public function creacionVerificacionCarpetas($blogId)
    {
        try {
            //verificación y o creación de la carpeta para las imagenes basadas en el nombre de la pagina, utilizando su slug
            if (!file_exists(public_path('/storage/images/' . $blogId))) {
                mkdir(public_path('/storage/images/' . $blogId), 0755, true);
                return true;
            } elseif (file_exists(public_path('/storage/images/' . $blogId))) {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function uploadImagen($img, $blogId)
    {
        try {
            //verificar el archivo y la carpeta contenedora
            if ($img && self::creacionVerificacionCarpetas($blogId)) {
                //nombre del archivo formateado a md5
                $imgNewfileName = md5($img->getClientOriginalName());

                //guardar la imagen en el storage
                if ((ImageManagerStatic::make($img->getRealPath())->width() > ImageManagerStatic::make($img->getRealPath())->height()) || (ImageManagerStatic::make($img->getRealPath())->width() == ImageManagerStatic::make($img->getRealPath())->height())) { //check dimension of image
                    $imgRenderized = ImageManagerStatic::make($img->getRealPath())->resize(720, null, function ($constraint) { //resize image based on width
                        $constraint->aspectRatio();
                    })->resizeCanvas(720, null);
                    $imgRenderizedThumb = ImageManagerStatic::make($img->getRealPath())->resize(250, null, function ($constraint) { //resize image based on width
                        $constraint->aspectRatio();
                    })->resizeCanvas(250, null);
                } elseif (ImageManagerStatic::make($img->getRealPath())->width() < ImageManagerStatic::make($img->getRealPath())->height()) {
                    $imgRenderized = ImageManagerStatic::make($img->getRealPath())->resize(null, 720, function ($constraint) { //Resize image based on height
                        $constraint->aspectRatio();
                    })->resizeCanvas(null, 720);
                    $imgRenderizedThumb = ImageManagerStatic::make($img->getRealPath())->resize(null, 250, function ($constraint) { //Resize image based on height
                        $constraint->aspectRatio();
                    })->resizeCanvas(null, 250);
                }
                //$imgRenderized = ImageManagerStatic::make($img->getRealPath());
                $imgRenderized->save(public_path('/storage/images/' . $blogId . '/' . $imgNewfileName . '.' . $img->getClientOriginalExtension()), 100);
                $imgRenderizedThumb->save(public_path('/storage/images/' . $blogId . '/' . $imgNewfileName . '_thumb.' . $img->getClientOriginalExtension()), 100);
                //ruta referencial
                return Storage::url('public/images/' . $blogId . '/' . $imgNewfileName . '_thumb.' . $img->getClientOriginalExtension());
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showWithSlug(Blog $blog, $slug)
    {
        //$blog = Blog::where('slug', request('slug'))->first();
        if(Str::slug($blog->slug , "-") != $slug){
            abort(404);
        }else{
            return Inertia::render('Blog', compact('blog'));
        }
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

    public function toggleStatus(Blog $blog){
        try {
            if(auth()->user()->id == $blog->user_id){
                if($blog->status == 2){
                    $blog->status = 1;
                }else{
                    $blog->status = 2;
                }
                $blog->timestamps = false;
                $blog->save();
                return redirect()->back();
            }else{
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
}
