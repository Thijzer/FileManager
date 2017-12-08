<?php

namespace FileManager;

interface GeneratorInterface
{
    public static function generate(string $path) : string;
}
