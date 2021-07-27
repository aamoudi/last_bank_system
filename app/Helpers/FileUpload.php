<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;

trait FileUpload
{

    protected  $filePath;

    function uploadFile(UploadedFile $uploadedFile, $folder, $disk = 'public', $filename)
    {
        $name = !is_null($filename) ? $filename : Str::random(10);
        $this->filePath = $folder . $name . '.' . $uploadedFile->getClientOriginalExtension();
        $imageFullName = $name . '.' . $uploadedFile->getClientOriginalExtension();
        $file = $uploadedFile->storeAs($folder, $imageFullName, $disk);
        return $file;
    }
}
