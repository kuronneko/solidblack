<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic;


class ImageService
{
    public static function creacionVerificacionCarpetas($blogId)
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

    public static function uploadImagen($img, $blogId)
    {
        try {
            //verificar el archivo y la carpeta contenedora
            if ($img && self::creacionVerificacionCarpetas($blogId)) {
                //nombre del archivo formateado a md5
                $imgNewfileName = md5($img->getClientOriginalName() . Str::random(4));

                //guardar la imagen en el storage
                if ((ImageManagerStatic::make($img->getRealPath())->width() > ImageManagerStatic::make($img->getRealPath())->height()) || (ImageManagerStatic::make($img->getRealPath())->width() == ImageManagerStatic::make($img->getRealPath())->height())) { //check dimension of image
                    $imgRenderized = ImageManagerStatic::make($img->getRealPath())->resize(1080, null, function ($constraint) { //resize image based on width
                        $constraint->aspectRatio();
                    })->resizeCanvas(1080, null);
                    $imgRenderizedThumb = ImageManagerStatic::make($img->getRealPath())->resize(250, null, function ($constraint) { //resize image based on width
                        $constraint->aspectRatio();
                    })->resizeCanvas(250, null);
                } elseif (ImageManagerStatic::make($img->getRealPath())->width() < ImageManagerStatic::make($img->getRealPath())->height()) {
                    $imgRenderized = ImageManagerStatic::make($img->getRealPath())->resize(null, 1080, function ($constraint) { //Resize image based on height
                        $constraint->aspectRatio();
                    })->resizeCanvas(null, 1080);
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
}
