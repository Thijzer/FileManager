<?php

namespace File;

use FileManager\Adapter\FSAdapter;

class FileCreator
{
    public static function createAdaptableFile(FilePath $filePath, FSAdapter $adapter): File
    {
        $file = new File($filePath);
        $file->getFileContent()->setAdapter($adapter);

        return $file;
    }
}