<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

class FileService
{
    public function downloadFile(UploadedFile $file,string $path)
    {
        $this->createDir($path);
        $name = $file->getClientOriginalName();
        $data = $file->getContent();
        file_put_contents($path.'/'.$name,$data);
    }

    public function fileDelete(string $path,string $filename)
    {
        if (file_exists($path.'/'.$filename)){
            unlink($path.'/'.$filename);
            $this->dirDelete($path);
        }
    }
    public function dirDelete(string $path)
    {
        if (is_dir($path)) {
            $files = scandir($path);

            $files = array_diff($files, ['.','..']);

            if (empty($files)) {
                rmdir($path);
            }
        }
    }
    public function filesDelete(Collection $collection)
    {
        foreach ($collection as $item){
            $this->fileDelete($item->path,$item->name);
        }
    }
    public function createDir(string $path)
    {
        if (!is_dir($path)){
            mkdir($path,0777,true);
        }
    }
}
