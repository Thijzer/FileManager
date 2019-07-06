<?php

namespace FileManager;

use File\File;
use File\FileCollection;
use File\FilePath;

interface ActionableFileInterface
{
    public function isFile(FilePath $filename): bool;

    public function getFile(FilePath $filename):? File;

    public function findFiles(array $directoryList): FileCollection;

    public function addFile(File $file): void;

    public function addFiles(FileCollection $files): void;

    public function removeFile(FilePath $file): void;

    public function removeFiles(FileCollection $files): void;

    public function moveFile(FilePath $file, string $location): void;

    public function copyFile(FilePath $source, FilePath $destination): void;

    public function renameFile(FilePath $file, FilePath $newFilename): void;
}
