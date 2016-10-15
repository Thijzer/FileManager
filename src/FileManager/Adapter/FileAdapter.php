<?php

namespace FileManager\Adapter;

interface FileAdapter
{
    public function getContent();

    public function setContent(string $content);
//
//    public function writeStream();
//
//    public function getRealName();
}
