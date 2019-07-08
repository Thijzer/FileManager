<?php

namespace FileManager\Commands;

class CommandResolver
{
    private $commands = [];

    public function addCommands(Command $command, $resolution): void
    {
        $this->commands[$command->getReference()] = $resolution;
    }

    public function resolve(Command $command)
    {
        $resolution = $this->commands[$command->getReference()];

        unset($this->commands[$command->getReference()]);

        return $resolution;
    }
}