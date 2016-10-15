<?php

namespace FileManager;

class Hash
{
    public static function fromPath($path)
    {
        return hash('crc32b', $path);
    }
}
