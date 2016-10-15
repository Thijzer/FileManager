<?php

namespace FileManager\Commands;

use FileManager\File;

class FileCommandCollection
{
    /** @var CommandRecorder */
    private $command;

    public function __construct(CommandRecorder $command)
    {
        $this->command = $command;
    }

    public function relativePath($fileName) // strips filemanager root dir
    {
        return $fileName;
    }

    public function isFile(File $file)
    {
        $this->command->record(FileCommand::isFile($this->relativePath($file->getFilename())));
    }

    public function rename($fileA, $fileB)
    {
        $this->command->record(FileCommand::renameFile($this->relativePath($fileA), $this->relativePath($fileB)));
    }

    public function delete($filename)
    {
        $this->command->record(FileCommand::removeFile($this->relativePath($filename)));
    }

    public function makeFile($filename)
    {
        $this->command->record(FileCommand::createFile($this->relativePath($filename)));
    }

    public function move(File $fileA, string $directory)
    {
        $this->command->record(FileCommand::moveFile($this->relativePath($fileA), $this->relativePath($directory)));
    }

    public function __construct($rootDirectory = null, CommandRecorder $command)
    {
        if (!$this->isDir($rootDirectory)) {
            throw new \Exception(sprintf('%s is not a directory', $rootDirectory));
        }
        $this->rootDirectory = $rootDirectory;
        $this->command = $command;
    }


}
