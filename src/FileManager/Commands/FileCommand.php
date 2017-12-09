<?php

namespace FileManager\Commands;

use FileManager\File;

class FileCommand implements Command
{
    private $action;
    private $file;
    private $resolution;

    public function __construct(string $action, File $file, $resolution = null)
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

    public function getAction()
    {
        return $this->action;
    }

    public static function createFile($path)
    {
        return new self(FileAction::CREATE, $path);
    }

    public static function moveFile($path, $location)
    {
        return new self(FileAction::MOVE, $path, $location);
    }

    public static function copyFile($path, $pathname)
    {
        return new self(FileAction::COPY, $path, $pathname);
    }

    public static function removeFile($pathName)
    {
        return new self(FileAction::DELETE, $pathName);
    }

    public static function renameFile($path, $pathname)
    {
        return new self(FileAction::RENAME, $path, $pathname);
    }

    public static function updateFile($path)
    {
        return new self(FileAction::UPDATE, $path);
    }

    public static function isFile($path)
    {
        return new self(FileAction::IS_FILE, $path);
    }
}
