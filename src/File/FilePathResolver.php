<?php

namespace File;

use FileManager\FileManager;

class FilePathResolver
{
    /** @var FileManager */
    private $fileManager;

    public function __construct(FileManager $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    public function resolveFile(File $file): string
    {
        return implode(DIRECTORY_SEPARATOR, [
            $this->fileManager->getRoot(),
            $file->getFilePath()->getPath()
        ]);
    }

    public function resolvePath(FilePath $filePath): string
    {
        return implode(DIRECTORY_SEPARATOR, [
            $this->fileManager->getRoot(),
            $filePath->getPath()
        ]);
    }

    public function resolveDirectory($directory): string
    {
        return implode(DIRECTORY_SEPARATOR, [
            $this->fileManager->getRoot(),
            $directory
        ]);
    }
}