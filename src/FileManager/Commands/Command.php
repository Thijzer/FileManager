<?php

namespace FileManager\Commands;

interface Command
{
    public function getAsset();

    public function getResolution();

    public function getAction();
}
