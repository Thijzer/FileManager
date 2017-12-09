<?php

namespace FileManager\Commands;

class DirCommand implements Command
{
    private $action;
    private $directory;
    private $resolution;

    public function __construct(string $action, string $directory, $resolution = null)
    {
        $this->directory = $directory;
        $this->action = $action;
        $this->resolution = $resolution;
    }

    public function getAsset()
    {
        return $this->directory;
    }

    public function getResolution()
    {
        return $this->resolution;
    }

    public function getAction()
    {
        return $this->action;
    }

    public static function createDir($dir)
    {
        return new self(DirAction::CREATE_DIR, $dir);
    }

    public static function moveDir($dir, $location)
    {
        return new self(DirAction::MOVE_DIR, $dir, $location);
    }

    public static function removeDir($dir)
    {
        return new self(DirAction::DELETE_DIR, $dir);
    }

    public static function renameDir($dir, $dirName)
    {
        return new self(DirAction::RENAME_DIR, $dir, $dirName);
    }

    public static function readDir($dir)
    {
        return new self(DirAction::READ_DIR, $dir);
    }

    public static function isDir($dir)
    {
        return new self(DirAction::IS_DIR, $dir);
    }

    public static function findFiles($dir, array $files)
    {
        return new self(DirAction::FIND, $dir, $files);
    }
}
