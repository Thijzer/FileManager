<?php

namespace FileManager\Commands;

class CommandResolver
{
    private $resolutions = [];
    public function addSolution(Command $command, $resolution): void
    {
        $this->resolutions[$command->getReference()] = $resolution;
    }
    public function resolve(Command $command)
    {
        $resolution = $this->resolutions[$command->getReference()];

        unset($this->resolutions[$command->getReference()]);

        return $resolution;
    }
}