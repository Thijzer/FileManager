<?php

namespace Utils;

class Md5HashGenerator implements Generator
{
    public static function generate(string $path): string
    {
        return md5($path);
    }
}