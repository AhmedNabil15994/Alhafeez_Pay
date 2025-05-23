<?php

namespace Modules\Core\Traits\Attachment;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

trait Attachment
{
    private $imageExtensions = [
        'jpg',
        'jpeg',
        'png',
        'svg',
        'rgb',
    ];

    /**
     * @param $key
     * @param $array
     * @param $value
     * @return mixed
     */
    private static function inArray($key, $array, $value)
    {
        $return = array_key_exists($key, $array) ? $array[$key] : $value;
        return $return;
    }

    /**
     * @param $file
     * @param $folder_name
     * @param null $model
     * @param null $col_name
     * @param array $options
     * @return string
     */
    public static function addAttachment($file, $folder_name, $model = null, $col_name = null, array $options = [])
    {
        $path = static::uploadAttach($file, $folder_name, $model, $options);
        if ($model):
            $model->$col_name = $path;
        $model->save();
        endif;

        return $path;
    }

    public static function uploadAttach($file, $folder_name, $model = null, array $options = [])
    {
        $save = self::inArray('save', $options, 'original');
        $size = self::inArray('size', $options, 400);
        $quality = self::inArray('quality', $options, 100);
        $folder_name = $folder_name . '/' . ($model ? $model->id  : "");
        $extension = "png";

        if ($extension == 'svg' || $save == 'original'):
            $path = $file->store($folder_name); else:
            $path = self::resizePhoto($extension, $destinationPath, $file, $size, $quality);
        endif;
        return "storage/".$path;
    }

    

    /**
     * @param $file
     * @param $oldFilesPath
     * @param $folder_name
     * @param null $model
     * @param null $col_name
     * @param array $options
     * @return string
     */
    public static function updateAttachment($file, $oldFilesPath, $folder_name, $model = null, $col_name = null, array $options = [])
    {
        self::deleteAttachment($oldFilesPath);
        return self::addAttachment($file, $folder_name, $model, $col_name, $options);
    }

    /**
     * @param $file_path
     * @return bool
     */
    public static function deleteAttachment($file_path)
    {
        $currentDisk = config("filesystems.default");
        $count = 1;
        // dd($file_path,str_replace("storage", config("filesystems.disks.$currentDisk.root"), $file_path, $count));
        foreach ((array)$file_path as $file) {
            File::delete(str_replace("storage", config("filesystems.disks.$currentDisk.root"), $file));
        }
        return true;
    }

    /**
     * @param $file_path
     * @return bool
     */
    public static function deleteFolder($folder)
    {
        $currentDisk = config("filesystems.default");
        $count = 1;
        File::deleteDirectory(config("filesystems.disks.$currentDisk.root")  . "/". $folder);
        return true;
    }

    /**
     * @param $extension
     * @param string $folder
     * @param $file
     * @param int $size
     * @param int $quality
     * @return string
     */
    private static function resizePhoto($extension, $folder_name, $file, $size = 400, $quality = 100)
    {
        $image = $size . '-' . time() . '' . rand(11111, 99999) . '.' . $extension;
        $path  = $folder_name."/".$image;
        
        $resize_image = Image::make($file);
        $imageResult = $resize_image->resize($size, null, function ($constraint) {
            $constraint->aspectRatio();
        })->encode($extension, $quality);
        Storage::put($path, $imageResult);
        return $path;
    }
}
