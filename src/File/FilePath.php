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
    /**
     * @var string
     */
    private $relativePath;
    /**
     * @var string
     */
    private $rootDirectory;

    /**
     * FilePath constructor.
     *
     * @param string $relativePath
     * @param string|null $rootDirectory
     */
    public function __construct(string $relativePath, string $rootDirectory = null)
    {
        $this->relativePath = $relativePath;
        $this->rootDirectory = rtrim($rootDirectory, DIRECTORY_SEPARATOR);
    }

    public function getAbsolutePath(): string
    {
        return implode(DIRECTORY_SEPARATOR, [
            $this->rootDirectory,
            $this->relativePath,
        ]);
    }

    public function getPath(): string
    {
        return $this->relativePath;
    }

    public function getHash(): string
    {
        return Crc32bHashGenerator::generate($this->getPath());
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
        return $this->getPath();
    }
}