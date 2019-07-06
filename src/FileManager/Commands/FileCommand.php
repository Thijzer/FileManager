<?php

namespace FileManager\Commands;

use File\File;
use File\FilePath;

class FileCommand implements Command
{
    private $action;
    private $file;
    private $resolution;

    public function __construct(string $action, $file, $resolution = null)
    {
        $this->action = $action;
        $this->file = $file;
        $this->resolution = $resolution;
    }

    public function getAsset()
    {
        return $this->file;
    }

    public function getResolution()
    {
        return $this->resolution;
    }

    public function getAction():string
    {
        return $this->action;
    }

    public function getReference(): string
    {
       return implode(DIRECTORY_SEPARATOR, [$this->getAsset()->getHash(), $this->action]);
    }

    public static function getFile(string $filename): self
    {
        return new self(FileAction::GET_FILE, new FilePath($filename));
    }

    public static function findFiles(array $filenames): self
    {
        return new self(FileAction::FIND_FILES, $filenames);
    }

    public static function addFile($path): self
    {
        return new self(FileAction::ADD, $path);
    }

    public static function moveFile($path, $location): self
    {
        return new self(FileAction::MOVE, $path, $location);
    }

    public static function copyFile(string $path, string $destination): self
    {
        return new self(FileAction::COPY, new FilePath($path), new FilePath($destination));
    }

    public static function removeFile(string $pathName): self
    {
        return new self(FileAction::DELETE, new FilePath($pathName));
    }

    public static function renameFile($path, $pathname): self
    {
        return new self(FileAction::RENAME, new FilePath($path), new FilePath($pathname));
    }

    public static function updateFile($path): self
    {
        return new self(FileAction::UPDATE, $path);
    }

    public static function isFile($path): self
    {
        return new self(FileAction::IS_FILE, new FilePath($path));
    }
}