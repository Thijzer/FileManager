<?php

namespace FileManager;

class HashGenerator implements GeneratorInterface
{
    public static function generate(string $path) : string
    {
        return hash('crc32b', $path);
    }
}
