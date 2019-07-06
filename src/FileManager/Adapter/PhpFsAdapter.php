<?php

namespace FileManager\Adapter;

use File\File;
use File\FileCollection;
use File\FileCreator;
use File\FilePath;
use File\FilePathResolver;

class PhpFsAdapter implements FSAdapter
{
    /** @var FilePathResolver */
    private $pathResolver;

    public function __construct(FilePathResolver $pathResolver)
    {
        $this->pathResolver = $pathResolver;
    }

    public function addDirectory(FilePath $directoryName): void
    {
        $folder = $this->pathResolver->resolvePath($directoryName);
        !is_dir($folder) && !mkdir($folder) && !is_dir($folder);
    }

    public function isDirectory(string $directoryName): bool
    {
        return is_dir($directoryName);
    }

    public function removeDirectory(FilePath $directoryName): void
    {
        rmdir($this->pathResolver->resolvePath($directoryName));
    }

    public function getDirectoryList(FilePath $directoryName): array
    {
        return glob($this->pathResolver->resolvePath($directoryName));
    }

    public function findDirectory(FilePath $directoryName): string
    {
        // TODO: Implement findDirectory() method.
    }

    public function renameDirectory(FilePath $source, FilePath $destination): void
    {
        rename(
            $this->pathResolver->resolvePath($source),
            $this->pathResolver->resolvePath($destination)
        );
    }

    public function moveDirectory(FilePath $source, FilePath $destination): void
    {
        $this->renameDirectory($source, $destination);
    }

    public function isFile(FilePath $filename): bool
    {
        return file_exists($this->pathResolver->resolvePath($filename));
    }

    public function getFile(FilePath $filename):? File
    {
        if (!$this->isFile($filename)) {
            return null;
        }

        return FileCreator::createAdaptableFile($filename, $this);
    }

    public function findFiles($directoryList): FileCollection
    {
        $files = new FileCollection();
        foreach ($directoryList as $directory) {
            foreach ($this->scan($directory) as $filename) {
                $files->add(new File(new FilePath($directory.$filename)));
            }
        }

        return $files;
    }

    private function scan(string $directory): array
    {
        $directory = $this->pathResolver->resolveDirectory($directory);

        return array_diff(array_filter(scandir($directory, SCANDIR_SORT_ASCENDING), function ($item) use ($directory) {
            return !is_dir($directory.$item);
        }), []);
    }

    public function addFile(File $file): void
    {
        $path = $this->pathResolver->resolveFile($file);

        try {
            $localFile = fopen($path, 'wb+');
            fwrite($localFile, $this->getContent($file));
            fclose($localFile);
        } catch (\Exception $e) {
            throw new \Exception('Error Saving File ' . $path, $e);
        }
    }

    public function getContent(File $file): string
    {
        return file_get_contents($this->pathResolver->resolveFile($file));
    }

    public function addFiles(FileCollection $files): void
    {
        /** @var File $file */
        foreach ($files as $file) {
            $this->addFile($file);
        }
    }

    public function removeFile(FilePath $file): void
    {
        unlink($this->pathResolver->resolvePath($file));
    }

    public function removeFiles(FileCollection $files): void
    {
        foreach ($files as $file) {
            $this->removeFile($file);
        }
    }

    public function moveFile(FilePath $source, string $destination): void
    {
        $this->renameFile($source, new FilePath($destination));
    }

    public function copyFile(FilePath $source, FilePath $destination): void
    {
        copy(
            $this->pathResolver->resolvePath($source),
            $this->pathResolver->resolvePath($destination)
        );
    }

    public function renameFile(FilePath $filename, FilePath $newFilename): void
    {
        rename(
            $this->pathResolver->resolvePath($filename),
            $this->pathResolver->resolvePath($newFilename)
        );
    }
}
