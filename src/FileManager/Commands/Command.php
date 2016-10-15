<?php

namespace FileManager\Commands;

interface Command
{
    public function getFile();
    public function getResolution();
    public function getAction();
}
