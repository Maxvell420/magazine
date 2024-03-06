<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;

trait FileOperationsTrait
{
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
            // Get the list of files and directories in the specified path
            $files = scandir($path);

            // Remove '.' and '..' from the list (current and parent directory)
            $files = array_diff($files, array('.', '..'));

            // Check if the directory is empty
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
            mkdir($path);
        }
    }
}
