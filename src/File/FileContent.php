<?php

namespace File;

// basically a pointer to what is the content of a file or a cache
// we won't hold content in memory but it in cache as it's to large
// when completed we mv when ready
// This is adapter specific, we need the adapter, FilePath and the Filemanager FullPath to make this work

use FileManager\Adapter\FSAdapter;

class FileContent
{
    /** @var File */
    private $file;
    /** @var FSAdapter */
    private $adapter;

    public function __construct(File $file)
    {
        $this->file = $file;
    }

    public function setAdapter(FSAdapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function getContent(): string
    {
        return $this->adapter->getContent($this->file);
    }

    public function __toString(): string
    {
        return $this->getContent();
    }
}