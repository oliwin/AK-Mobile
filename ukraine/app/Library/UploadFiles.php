<?php

/**
 * Created by PhpStorm.
 * User: Oleg
 * Date: 05.09.2016
 * Time: 12:57
 */

namespace App\Library;

use App\Http\Requests;

use Illuminate\Support\Facades\Input;

use Validator;


class UploadFiles
{

    private static $filename;
    private static $type;
    private static $id;
    private static $key;
    public static $files;
    public static $json = false;
    public static $file;

    public static function initUpload($inputName, $type, $id = null, $key = null)
    {
        self::$filename = $inputName;
        self::$type = $type;
        self::$id = $id;
        self::$key = $key;

        self::handle();
    }

    public static function fillArray($data = array())
    {

        if (!empty(self::$key)) {
            self::$files[] = array(
                "file" => $data["path"] . '/' . $data["filename"],
                self::$key => self::$id
            );

        } else {

            self::$files[] = array(
                "file" => $data["path"] . '/' . $data["filename"],
                "path" => $data["path"]
            );
        }

    }

    public static function fileByIndex($index)
    {
        return self::$files[$index]["file"];
    }

    public static function exist()
    {
        return (count(self::$files)) ? true : false;
    }

    public static function oneImage()
    {
        return (isset(self::$files[0]["image"])) ? self::$files[0]["image"] : "";
    }

    public static function destinationPath()
    {

        switch (self::$type) {
            case "excel":
                $path = "upload/excel";
                break;
            case "category":
                $path = "uploads/categories";
                break;
            case "courier":
                $path = "uploads/couriers";
                break;
            case "user":
                $path = "uploads/users";
                break;
            case "place":
                $path = "uploads/places";
                break;
            case "result_test":
                $path = "results/test";
                break;
            default:
                $path = "uploads/custom";
                break;
        }

        return $path;
    }

    public static function handle()
    {

        $allowedFileTypes = config('app.allowedFileTypes');
        $maxFileSize = config('app.maxFileSize');
        $files = Input::file(self::$filename);

        if (!$files) {
            throw new \Exception(["message" => "Select file"]);
        }

        foreach ($files as $key => $file) {

            $rules = array('file' => 'mimetypes:' . $allowedFileTypes . '|max:' . $maxFileSize);
            $validator = Validator::make(array('file' => $file), $rules);

            if ($validator->fails()) {

                self::$file = $file->getClientOriginalName();
                throw new \Exception("Upload file error UploadFile.php: " . self::$file);
            }

            $size = $file->getSize();
            $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $storeName = uniqid(rand(), true) . '.' . $extension;
            $destinationPath = self::destinationPath();

            $file->move($destinationPath, $storeName);
            self::fillArray(['filename' => $storeName, 'size' => $size, 'extention' => $extension, 'path' => $destinationPath]);
        }
    }
}