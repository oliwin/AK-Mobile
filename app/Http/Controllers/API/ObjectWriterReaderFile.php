<?php

namespace App\Http\Controllers\API;

use File;

use Carbon\Carbon;

/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 5/13/17
 * Time: 9:12 PM
 */
class ObjectWriterReaderFile
{

    public $file = "config.json";

    public $path = "/data/";

    private $limit = 5;

    private $content;


    public function __construct()
    {
        $this->path = public_path() . $this->path;

        $this->file = $this->path . time() . '-' . $this->file;

        $this->countDirectoryFiles();

    }

    private function countDirectoryFiles()
    {

        $files = scandir($this->path);

        return count($files) - 2;

    }

    private function sortFilesByModifyTime()
    {
        $timeModify = [];

        $files = array_diff(scandir($this->path), array(".", ".."));

        foreach ($files as $fileInfo) {

            $timeModify[filectime($this->path.$fileInfo)][] = $fileInfo;
        }

        return $timeModify;

    }

    private function deleteOlderFile()
    {

        $files = $this->sortFilesByModifyTime();

        $files = array_first($files);

        $file = current($files);

        File::delete($this->path . $file);
    }

    public function write($object)
    {
        if ($this->limit < $this->countDirectoryFiles()) {
            $this->deleteOlderFile();
        }

        $json = json_encode($object);

        File::put($this->file, $json);
    }

    public function read()
    {
      $files = $this->sortFilesByModifyTime();

      $files = array_first($files);

      $this->file = current($files);

      $this->content = File::get($this->path.$this->file);

    }

    public function toJson()
    {

        return response($this->content)->header('Content-Type', "json");
    }

}
