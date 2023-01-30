<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Inertia\Inertia;
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
        $blogs = Blog::where('user_id', Auth::user()->id)->orderBy("created_at", 'desc');
        $search = "";
        if (request()->has("search")) {
            $search = request("search");
            $blogs = $blogs->where('title', 'like', '%' . $search . '%')->where('user_id', Auth::user()->id);
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
        return Inertia::render('Blog/Create');
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
            'url' => self::uploadImagen($request->file('upload'))
            //'url' => asset('storage/imagenes/' . $fileName)
        ]);
    }

    public function creacionVerificacionCarpetas()
    {
        try {
            //verificación y o creación de la carpeta para las imagenes basadas en el nombre de la pagina, utilizando su slug
            if (!file_exists(public_path('/storage/imagenes/'))) {
                mkdir(public_path('/storage/imagenes/'), 0755, true);
                return true;
            } elseif (file_exists(public_path('/storage/imagenes/'))) {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function uploadImagen($img)
    {
        try {
            //verificar el archivo y la carpeta contenedora
            if ($img && self::creacionVerificacionCarpetas()) {
                //nombre del archivo formateado a md5
                $imgNewfileName = md5($img->getClientOriginalName());

                //guardar la imagen en el storage
                if ((ImageManagerStatic::make($img->getRealPath())->width() > ImageManagerStatic::make($img->getRealPath())->height()) || (ImageManagerStatic::make($img->getRealPath())->width() == ImageManagerStatic::make($img->getRealPath())->height())) { //check dimension of image
                    $imgRenderized = ImageManagerStatic::make($img->getRealPath())->resize(720, null, function ($constraint) { //resize image based on width
                        $constraint->aspectRatio();
                    })->resizeCanvas(720, null);
                } elseif (ImageManagerStatic::make($img->getRealPath())->width() < ImageManagerStatic::make($img->getRealPath())->height()) {
                    $imgRenderized = ImageManagerStatic::make($img->getRealPath())->resize(null, 720, function ($constraint) { //Resize image based on height
                        $constraint->aspectRatio();
                    })->resizeCanvas(null, 720);
                }
                //$imgRenderized = ImageManagerStatic::make($img->getRealPath());
                $imgRenderized->save(public_path('/storage/imagenes/' . $imgNewfileName . '.' . $img->getClientOriginalExtension()), 100);

                //ruta referencial
                $imgUrl = Storage::url('public/imagenes/' . $imgNewfileName . '.' . $img->getClientOriginalExtension());
                return $imgUrl;
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
        Blog::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'content' => $request->content,
        ]);
        return redirect()->route('blog.index');
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
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->back();
    }
}
