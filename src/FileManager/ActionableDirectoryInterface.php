<?php

namespace FileManager;

interface ActionableDirectoryInterface
{
    public function addDirectory($directoryName);

    public function removeDirectory($directoryName);

    public function getDirectoryList($directoryName = null);
}
