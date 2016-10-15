<?php

namespace FileManager;

class FilePath
{
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public static function fromPath($path)
    {
        return new self($path);
    } 

    public function getFullPath()
    {
        return $this->path;
    }

    public function getHash()
    {
        return Hash::fromPath($this->path);
    }

    public function isIdentical(FilePath $filePath)
    {
        return ($this->getHash() === $filePath->getHash());
    }

    public function __toString()
    {
        return $this->path;
    }
}
