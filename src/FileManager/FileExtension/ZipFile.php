<?php

namespace FileManager\FileExtension;

use FileManager\File;
use FileManager\FileManager;

class ZipFile extends File
{
    public function __construct($fullPath, $content)
    {
        parent::__construct($fullPath, $content);
        $this->fm = new FileManager();
    }
}
