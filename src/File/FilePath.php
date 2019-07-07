<?php

namespace File;

use Utils\Crc32bHashGenerator;

/**
 * Class FilePath
 * FilePath should be initialized locally
 * but functions as relative to the root file manager
 * @package File
 */
class FilePath
{
    private $path;

    public function __construct(...$path)
    {
        $this->path = implode(DIRECTORY_SEPARATOR, $path);
    }

    /**
     * - within local contraints
     *
     */
    public function getAbsolutePath()
    {

    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getHash(): string
    {
        return Crc32bHashGenerator::generate($this->path);
    }

    public function isEqual(FilePath $filePath): bool
    {
        return $this->is($filePath->getPath());
    }

    public function is(string $filePath): bool
    {
        return $this->getPath() === $filePath;
    }

    public function __toString(): string
    {
        return $this->path;
    }
}