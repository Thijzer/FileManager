<?php

namespace FileManager;

interface FileManagerInterface extends ActionableInterface
{
    /** @return boolean */
    public function isFile($filename);

    /** @return boolean */
    public function isDirectory($directoryName);

    public function persist(IndexInterface $indexInterface);

    public function find(...$query);
}
