<?php

namespace FileManager;

class Paginator
{
    public function getFiles($limit = 0, $offset = 0)
    {
        $tmp = [];
        $files = array_slice($this->index()->getFiles(), $offset, $limit);
        foreach ($files as $hash => $file) {
            $tmp[$hash] = $this->index()->returnFile($file);
        }
        return $tmp;
    }
}
