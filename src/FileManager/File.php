<?php

namespace FileManager;

use FileManager\Adapter\FileAdapter;

class File extends \SplFileInfo implements FileAdapter
{
    private $path;
    private $content;

    public function __construct(string $path, string $content = null)
    {
        $this->path = FilePath::fromPath($path);
        $this->content = $content;
    }

/*    public static function create(string $path, FileAdapter $fileAdapter)
    {
        return new self($path, $fileAdapter);
    }*/

    public function getContent()
    {
        return $this->content;
    }

    public function setContent(string $content)
    {
        $this->content = $content;
    }

    public function getPath()
    {
        return $this->path;
    }
}
