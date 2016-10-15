<?php

namespace FileManager\Commands;

class CommandRecorder
{
    /** @var array | Command[] */
    private $commands = [];

    public function record(Command $command)
    {
        $this->commands[] = $command;
    }

    public function getRecordedCommands()
    {
        $commands = $this->commands;
        $this->commands = [];
        return $commands;
    }
}
