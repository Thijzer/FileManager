<?php

namespace FileManager;

use Criteria\FSCriteria;
use File\File;
use File\FileCollection;
use File\FilePathResolver;

use FileManager\Adapter\PhpFsAdapter;
use FileManager\Commands\CommandResolver;
use FileManager\Commands\DirCommand;
use FileManager\Commands\FileCommand;
use FileManager\Commands\CommandRecorder;
use FileManager\Handler\FSHandler;

class FileManager
{
    private $recorder;
    private $rootDirectory;
    private $handler;
    private $resolver;

    public function __construct(string $rootDirectory, string $adapterClass = null, CommandRecorder $recorder = null)
    {
        $this->rootDirectory = rtrim($rootDirectory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $this->recorder = $recorder ?? new CommandRecorder();
        if (null === $adapterClass) {
            $adapter = new PhpFsAdapter(new FilePathResolver($this));
        } else {
            $adapter = new $adapterClass(new FilePathResolver($this));
        }
        $this->resolver = new CommandResolver();
        $this->handler = new FSHandler($adapter, $this->resolver);
    }

    public function isFile(string $filename)
    {
        $this->recorder->record($command = FileCommand::isFile($filename));
        $this->persist();

        return $this->resolver->resolve($command);
    }

    public function getFile(string $filename):? File
    {
        $this->recorder->record($command = FileCommand::getFile($filename));
        $this->persist();

        return $this->resolver->resolve($command);
    }

    public function findFiles(FSCriteria $criteria = null): FileCollection
    {
        $this->recorder->record($command = DirCommand::scanDir($criteria ?? new FSCriteria()));
        $this->persist();

        return $this->resolver->resolve($command);
    }

    public function copyFile(string $file, $filename = null): void
    {
        $this->recorder->record(FileCommand::copyFile($file, $filename));
    }

    public function moveFile(File $file, string $directoryName): void
    {
        $this->recorder->record(FileCommand::moveFile($file, $this->relativeDir($directoryName)));
    }

    public function addFiles(array $files): void
    {
        foreach ($files as $file) {
            $this->addFile($file);
        }
    }

    public function addFile(File $file): void
    {
        $this->recorder->record(FileCommand::addFile($file));
    }

    public function updateFile(File $file): void
    {
        $this->recorder->record(FileCommand::updateFile($file));
    }

    public function removeFile($fileName): void
    {
        $this->recorder->record(FileCommand::removeFile($fileName));
    }

    public function removeFiles(array $files): void
    {
        foreach ($files as $fileName) {
            $this->removeFile($fileName);
        }
    }

    public function renameFile(string $filenameA, string $filenameB): void
    {
        $this->recorder->record(FileCommand::renameFile($filenameA, $filenameB));
    }

    public function renameDir($dirA, $dirB): void
    {
        $this->recorder->record(DirCommand::renameDir($this->relativeDir($dirA), $this->relativeDir($dirB)));
    }

    public function deleteDir($directoryName): void
    {
        $this->recorder->record(DirCommand::removeDir($this->relativeDir($directoryName)));
    }

    public function mkDir($directoryName): void
    {
        $this->recorder->record(DirCommand::createDir($this->relativeDir($directoryName)));
    }

    public function listDir($directoryName = ''): void
    {
        $this->recorder->record(DirCommand::readDir($this->relativeDir($directoryName)));
    }

    private function persist(): void
    {
        $this->handler->handleAllRecordings($this->recorder);
    }

    public function getRoot(): string
    {
        return $this->rootDirectory;
    }

    private function relativeDir(string $directoryName): string
    {
        return str_replace($this->rootDirectory, '', $directoryName);
    }

    public function __destruct()
    {
        $this->persist();
    }
}