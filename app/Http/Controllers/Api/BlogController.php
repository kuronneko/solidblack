<?php

namespace App\Http\Controllers\Api;

use App\Models\Blog;
use Inertia\Inertia;
use App\Models\Setting;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\BlogService;
use App\Services\ImageService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GetBlogRequest;
use App\Http\Resources\BlogResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreBlogRequest;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GetBlogRequest $request)
    {
        try {
            $categories = explode(',', $request->categories);

            $blogs = Blog::where('status', 2)
                ->whereHas('categories', function ($q) use ($categories) {
                    $q->whereIn('name', $categories);
                })
                ->skip(request('skip'))
                ->take(request('take'))
                ->orderBy('published_at', 'desc')
                ->get();

            return response()->success(
                data: BlogResource::collection($blogs),
                developerMessage: 'Registros recuperados.',
                userMessage: 'Registros recuperados exitosamente.'
            );
        } catch (ModelNotFoundException $exc) {
            return response()->fail(
                developerMessage: "Recurso no encontrado: {$exc->getMessage()}",
                userMessage: 'Hubo un problema al obtener los registros. Inténtalo más tarde.',
                httpCode: 404
            );
        } catch (QueryException $exc) {
            return response()->error(
                developerMessage: "Error de base de datos: {$exc->getMessage()}",
                userMessage: 'Hubo un problema al obtener los registros. Inténtalo más tarde.'
            );
        } catch (\Exception $exc) {
            return response()->error(
                developerMessage: $exc->getMessage(),
                userMessage: 'Hubo un problema al obtener los registros. Inténtalo más tarde.'
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
/*     public function show(Blog $blog, Category $category)
    {
        if (!$blog->categories->contains($category->id)) {
            return response()->fail(
                developerMessage: 'El recurso no está disponible.',
                userMessage: 'El recurso no está disponible.',
                httpCode: 404
            );
        }

        if ($blog->status != 2) {
            return response()->fail(
                developerMessage: 'El recurso no está disponible.',
                userMessage: 'El recurso no está disponible.',
                httpCode: 404
            );
        }

        try {
            return response()->success(
                data: new BlogResource($blog),
                developerMessage: 'Registros recuperados.',
                userMessage: 'Registros obtenida exitosamente.'
            );
        } catch (ModelNotFoundException $exc) {
            return response()->fail(
                developerMessage: "Recurso no encontrado: {$exc->getMessage()}",
                userMessage: 'Hubo un problema al obtener los registros. Inténtalo más tarde.',
                httpCode: 404
            );
        } catch (QueryException $exc) {
            return response()->error(
                developerMessage: "Error de base de datos: {$exc->getMessage()}",
                userMessage: 'Hubo un problema al obtener los registros. Inténtalo más tarde.'
            );
        } catch (\Exception $exc) {
            return response()->error(
                developerMessage: $exc->getMessage(),
                userMessage: 'Hubo un problema al obtener los registros. Inténtalo más tarde.'
            );
        }
    } */
}
