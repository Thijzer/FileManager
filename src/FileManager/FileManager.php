<?php

namespace FileManager;

use FileManager\Adapter\LFSAdapter;
use FileManager\Commands\DirCommand;
use FileManager\Commands\FileCommand;
use FileManager\Commands\CommandRecorder;
use FileManager\Adapter\AbstractAdapter;

class FileManager
{
    private $recorder;
    private $rootDirectory;
    private $adapter;

    public function __construct(
        string $rootDirectory,
        CommandRecorder $recorder = null,
        AbstractAdapter $adapter = null
    ) {
        $this->rootDirectory = rtrim($rootDirectory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $this->recorder = $recorder ?? new CommandRecorder();
        $this->adapter = $adapter ?? new LFSAdapter();
    }

    public function copyFile(File $file, $filename = null)
    {
        if (null === $filename) {
            $filename = $file->getFilename() . '-copy.' . $file->getExtension();
        }

        $this->recorder->record(FileCommand::copyFile($file, $filename));
    }

    public function moveFile(File $file, $newLocation)
    {
        if (!is_dir($newLocation)) {
            // throw
        }

        $this->recorder->record(FileCommand::moveFile($file, $this->relativeDir($newLocation)));
    }

    public function addFiles(array $files)
    {
        foreach ($files as $file) {
            $this->addFile($file);
        }
    }

    public function addFile(File $file)
    {
        $this->recorder->record(FileCommand::createFile($file));
    }

    public function updateFile(File $file)
    {
        $this->recorder->record(FileCommand::updateFile($file));
    }

    public function removeFile($fileName)
    {
        $this->recorder->record(FileCommand::removeFile($fileName));
    }

    public function removeFiles(array $files)
    {
        foreach ($files as $fileName) {
            $this->removeFile($fileName);
        }
    }

    public function findFile(array $fileList)
    {
        $this->recorder->record(DirCommand::findFiles($this->rootDirectory, $fileList));
        //$this->persist();
    }

    private function relativeDir(string $directoryName)
    {
        return str_replace($this->rootDirectory, '', $directoryName);
    }

    public function getDir()
    {
        return $this->rootDirectory;
    }

    public function renameDir($dirA, $dirB)
    {
        $this->recorder->record(
            DirCommand::renameDir($this->relativeDir($dirA), $this->relativeDir($dirB))
        );
    }

    public function deleteDir($directoryName)
    {
        $this->recorder->record(DirCommand::removeDir($this->relativeDir($directoryName)));
    }

    public function mkDir($directoryName)
    {
        $this->recorder->record(DirCommand::createDir($this->relativeDir($directoryName)));
    }

    public function listDir($directoryName = '')
    {
        $this->recorder->record(DirCommand::readDir($this->relativeDir($directoryName)));
    }

    public function persist()
    {
        $adapter = $this->adapter;
        $adapter->handle($this->recorder);
    }
}
