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
            if (!file_exists(public_path('/storage/blog/' . $blogId))) {
                mkdir(public_path('/storage/blog/' . $blogId), 0755, true);
                return true;
            } elseif (file_exists(public_path('/storage/blog/' . $blogId))) {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public static function createTempFolder()
    {
        try {
            $path = public_path('/storage/temp/');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            return true;
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public static function uploadImagen($img, $blogId)
    {
        try {
            if ($img) {
                // Define file names
                $mainFileName = md5($img->getClientOriginalName() . Str::random(4)) . '.' . $img->getClientOriginalExtension();
                $thumbFileName = pathinfo($mainFileName, PATHINFO_FILENAME) . '_thumb.' . pathinfo($mainFileName, PATHINFO_EXTENSION);

                if (env('FILESYSTEM_DISK') == 's3') {
                    self::createTempFolder();
                    $mainImagePath = public_path('/storage/temp/' . $mainFileName);
                    $thumbImagePath = public_path('/storage/temp/' . $thumbFileName);
                } else {
                    self::creacionVerificacionCarpetas($blogId);
                    $mainImagePath = public_path('/storage/blog/' . $blogId . '/' . $mainFileName);
                    $thumbImagePath = public_path('/storage/blog/' . $blogId . '/' . $thumbFileName);
                }

                // Resize and Save images
                self::resizeImage($img)[0]->save($mainImagePath, 100);
                self::resizeImage($img)[1]->save($thumbImagePath, 100);

                if (env('FILESYSTEM_DISK') == 's3') {
                    // Upload to S3 and delete local files
                    self::uploadImageToS3($mainImagePath, $mainFileName, $blogId);
                    return self::uploadImageToS3($thumbImagePath, $thumbFileName, $blogId);
                } else {
                    return Storage::url('public/blog/' . $blogId . '/' . $thumbFileName);
                }
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public static function uploadImageToS3($imagePath, $fileName, $blogId)
    {
        // Upload the image to S3
        $s3Path = Storage::putFileAs(
            env('AWS_UPLOAD_FOLDER') . '/' . $blogId,
            new \Illuminate\Http\File($imagePath),
            $fileName,
            'public'
        );

        // Generate the CDN link
        $cdnLink = str_replace(
            'nyc3.digitaloceanspaces.com',
            'nyc3.cdn.digitaloceanspaces.com',
            Storage::disk('s3')->url($s3Path)
        );

        // Delete the local file
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        return $cdnLink;
    }

    public static function resizeImage($img)
    {
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

        return [$imgRenderized, $imgRenderizedThumb];
    }
}
