<?php

namespace App\Traits;

use App\Models\Catalogs\File;
use Illuminate\Support\Facades\Storage;

trait Fileable
{
    public function storingFile($name, $path)
    {
        $newFile = new File();
        $newFile->name = $name;
        $newFile->path = $path;

        $this->files()->save($newFile);
    }

    public function removeFile($id)
    {
        $file = File::find($id);
        
        if (Storage::exists($file->path)) {
            Storage::delete($file->path);
        }

        $this->files()->where('id', $id)->delete();
    }

    public function removeAllFiles()
    {
        $this->files()->detach();
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function getTotalFiles()
    {
        return $this->files()->count();
    }
}
