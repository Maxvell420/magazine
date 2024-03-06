<?php

namespace App\Models;

use App\Traits\FileOperationsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class Photo extends Model
{
    use HasFactory,FileOperationsTrait;
    protected $fillable=['path','house_id','name'];
    public function photoFileDelete()
    {
        $this->fileDelete($this->path,$this->name);
    }
    public function downloadPhoto(UploadedFile $photo)
    {
        if (!is_dir($this->path)){
            mkdir($this->path);
        }
        file_put_contents($this->path.'/'.$this->name,$photo->getContent());
    }
}
