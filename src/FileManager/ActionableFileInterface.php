<?php

namespace FileManager;

interface ActionableFileInterface
{
    public function getFile($filename);

    public function getFileList();

    public function addFile(File $file);

    public function addFiles(array $files);

    public function removeFile(File $file);

    public function removeFiles(array $files);

    public function move(File $file, $location);

    public function copy(File $file, $location);

    public function rename(File $file, $newFilename);
}
