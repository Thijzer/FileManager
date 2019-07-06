<?php

namespace Criteria;

class FSCriteria
{
    private $filename;
    private $file;
    private $filter = [];
    private $path;
    private $sort;

    public function __construct()
    {
        $this->filename = new PathCriteria();
        $this->path = new PathCriteria();
        $this->file = new FileCriteria();
        $this->sort = new SortCriteria();
    }

    public function filename(): PathCriteria
    {
        return $this->filename;
    }

    public function file(): FileCriteria
    {
        return $this->file;
    }

    public function filter(callable $filter): void
    {
        $this->filter = $filter;
    }

    public function path(): PathCriteria
    {
        return $this->path;
    }

    public function sort(): SortCriteria
    {
        return $this->sort;
    }

    public function toArray(): array
    {
        return [
            'filename' => $this->filename->toArray(),
            'file' => $this->file->toArray(),
            'filter' => $this->filter,
            'path' => $this->path->toArray(),
            'sort' => $this->sort->getSort(),
        ];
    }
}
