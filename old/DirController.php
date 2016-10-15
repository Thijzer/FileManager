<?php

namespace FileManager\Commands;

class DirController
{
    /** @var CommandRecorder */
    private $command;
    /** @var null|string */
    private $rootDirectory;

    private function relativeDir($directoryName)
    {
        return str_replace($this->rootDirectory, '', $directoryName);
    }

    public function getDir()
    {
        return $this->rootDirectory;
    }

    public function isDir($directoryName)
    {
        $this->command->record(DirCommand::isDir($this->relativeDir($directoryName)));
    }

    public function rename($dirA, $dirB)
    {
        $this->command->record(DirCommand::renameDir($this->relativeDir($dirA), $this->relativeDir($dirB)));
    }

    public function deleteDir($directoryName)
    {
        $this->command->record(DirCommand::removeDir($this->relativeDir($directoryName)));
    }

    public function mkDir($directoryName)
    {
        $this->command->record(DirCommand::createDir($this->relativeDir($directoryName)));
    }

    public function listView($directoryName)
    {
        $this->command->record(DirCommand::readDir($this->relativeDir($directoryName)));
    }
    }
}
