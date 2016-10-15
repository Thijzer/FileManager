<?php

namespace FileManager;

interface IndexInterface
{
    public function getChangedFiles();

    public function getRemoveFiles();

   // public function getRemovedDirectories();

    // public function getChangedDirectories();
}
