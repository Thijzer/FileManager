<?php

namespace FileManager\Commands;

class CommandRecorder
{
    /** @var array | Command[] */
    private $commands = [];

    public function record(Command $command): void
    {
        $this->commands[] = $command;
    }

    /**
     * @return Command[]
     */
    public function getRecordedCommands(): array
    {
        $commands = $this->commands;
        $this->commands = [];

        return $commands;
    }
}