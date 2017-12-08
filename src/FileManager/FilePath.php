<?php

namespace FileManager;

class FilePath
{
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function getPath() : string
    {
        return $this->path;
    }

    public function getHash() : string
    {
        return HashGenerator::generate($this->path);
    }

    public function isEqual(FilePath $filePath) : bool
    {
        return ($this->getPath() === $filePath->getPath());
    }

    public static function createFromPath($path)
    {
        return new self($path);
    }

    public function __toString() : string
    {
        return $this->path;
    }
}
