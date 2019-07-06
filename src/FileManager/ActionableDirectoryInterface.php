<?php

namespace FileManager;

use File\FilePath;

interface ActionableDirectoryInterface
{
    public function addDirectory(FilePath $directoryName): void;

    public function removeDirectory(FilePath $directoryName): void;

    public function getDirectoryList(FilePath $directoryName): array;

    public function findDirectory(FilePath $directoryName): string;

    public function renameDirectory(FilePath $source, FilePath $destination): void;

    public function moveDirectory(FilePath $source, FilePath $destination): void;
}