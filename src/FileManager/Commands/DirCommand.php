<?php

namespace FileManager\Commands;

class DirCommand implements Command
{
    private $action;
    private $directory;
    private $resolution;

    public function __construct(string $action, $directory, $resolution = null)
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

    public function getAction(): string
    {
        return $this->action;
    }

    public function getReference(): string
    {
        return implode(DIRECTORY_SEPARATOR, [$this->action]);
    }

    public static function createDir($dir): self
    {
        return new self(DirAction::CREATE_DIR, $dir);
    }

    public static function moveDir($dir, $location): self
    {
        return new self(DirAction::MOVE_DIR, $dir, $location);
    }

    public static function removeDir($dir): self
    {
        return new self(DirAction::DELETE_DIR, $dir);
    }

    public static function renameDir($dir, $dirName): self
    {
        return new self(DirAction::RENAME_DIR, $dir, $dirName);
    }

    public static function readDir($dir): self
    {
        return new self(DirAction::READ_DIR, $dir);
    }

    public static function scanDir(array $dir): self
    {
        return new self(DirAction::SCAN_DIR, $dir);
    }

    public static function isDir($dir): self
    {
        return new self(DirAction::IS_DIR, $dir);
    }
}
