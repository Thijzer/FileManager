<?php

namespace Utils;

class Crc32bHashGenerator implements Generator
{
    public static function generate(string $path): string
    {
        return hash('crc32b', $path);
    }
}