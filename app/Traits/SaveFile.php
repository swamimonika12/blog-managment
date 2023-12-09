<?php

namespace App\Traits;

use ZipArchive;
use App\File;
use App\Models\Family;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Throwable;

trait SaveFile
{

    protected function saveFile($file, string $model_name, $is_from_web = false)
    {
        $filename = Str::random(30);
        if ($is_from_web) {
            $extension = 'png';
        } else {
            $extension = $file->getClientOriginalExtension();
        }
        while (Storage::exists("{$model_name}/{$filename}.{$extension}")) {
            $filename = Str::random(30);
        }
        if ($is_from_web) {
            Storage::put("{$model_name}/{$filename}.{$extension}", $file);
        } else {
            Storage::put("{$model_name}/{$filename}.{$extension}", file_get_contents($file->getRealPath()));
        }
        $path = "{$model_name}/{$filename}.{$extension}";
        return $path;
    }

    /**
     * @return string
     */
    protected function generateFileName($file, $path)
    {
        $filename = Str::random(20);

        // Make sure the filename does not exist, if it does, just regenerate
        while (Storage::exists($path . $filename . '.' . $file->getClientOriginalExtension())) {
            $filename = Str::random(20);
        }

        return $filename;
    }

    public function deleteDirectory($path)
    {
        // if (count(Storage::exists($path))) {
        try {
            //code...
            Storage::deleteDirectory($path);
        } catch (\Throwable $th) {
            //throw $th;
        }
        // }
    }

    public function deleteFile($path)
    {
        if (Storage::exists($path)) {
            Storage::delete($path);
        }
    }

    protected function saveFileFromUrl($url, string $model_name = "test")
    {
        try {
            $file  = file_get_contents($url);
        } catch (Throwable $th) {
            return null;
        }
        $url_array = explode('.', $url);
        $extension = end($url_array);
        if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
            $extension = 'jpg';
        }
        $filename = Str::random(30);
        while (Storage::exists("{$model_name}/{$filename}.{$extension}")) {
            $filename = Str::random(30);
        }

        if (Storage::put("{$model_name}/{$filename}.{$extension}", $file)) {
            return "{$model_name}/{$filename}.{$extension}";
        } else {
            null;
        }
    }

    public function createZip(array $metadata)
    {
        $filename = 'data.zip';
        if (isset($metadata['filename'])) {
            $filename = $metadata['filename'];
        }
        $files = [];
        if (isset($metadata['files']) && is_array($metadata['files'])) {
            $files = $metadata['files'];
        }
        $zip = new ZipArchive;
        $zip->open(storage_path($filename), ZipArchive::CREATE);
        foreach ($files as $file) {
            $url = null;
            if (isset($file['url'])) {
                $url = $file['url'];
            }
            $file_content = null;
            if (isset($file['file_content'])) {
                $file_content = $file['file_content'];
            }

            if (!$file_content && !$url) {
                continue;
            }
            if ($file_content) {
                if (!isset($file['filename'])) {
                    continue;
                }
            }

            if ($url) {
                $temp_filename = basename($url);
            }
            if (isset($file['filename'])) {
                $temp_filename = $file['filename'];
            }
            $zip->addFromString(
                $temp_filename,
                $file_content ?? file_get_contents($url)
            );
        }
        $zip->close();
        $data = readfile(storage_path($filename));
        unlink(storage_path($filename));
        return $data;
    }
}