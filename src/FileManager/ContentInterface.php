<?php

namespace FileManager;

use File\File;

interface ContentInterface
{
    public function getContent(File $file): string;
}