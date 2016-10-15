<?php

namespace FileManager;

class Indexer // implements IndexInterface
{
    const FILENAME = '.index.json';

    private $index;
    private $directory;
    private $indexedFiles = [];
    private $addedFiles = [];
    private $removedFiles = [];

    public function __construct($directory)
    {
        $this->directory = rtrim($directory, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
        $this->index = new File($this->directory.self::FILENAME);
    }

    public function getFileList()
    {
        $this->indexedFiles = !$this->indexedFiles ?
            (array) @json_decode($this->index->getContent(), true) :
            $this->indexedFiles
        ;

        return array_diff(array_merge(
            $this->indexedFiles,
            $this->addedFiles
        ), $this->removedFiles);
    }

    public function getFile($filename)
    {
        $file = new File($this->directory.$filename);
        $fullPathHash = $file->getHash();
        return (isset($this->getFileList()[$fullPathHash])) ?
            $this->returnFile($this->getFileList()[$fullPathHash]):
            $file;
    }

    public function moveFile(File $newFile, File $oldFile)
    {
        $this->addFile($newFile);
        $this->removeFile($oldFile);
    }

    public function removeFile(File $file)
    {
        $this->removedFiles[$file->getHash()] = json_decode(json_encode($file), true);
    }

    public function addFile(File $file)
    {
        $this->addedFiles[$file->getHash()] = json_decode(json_encode($file), true);
    }

    public function find(array $needles, $sensitive = true, $offset = 0)
    {
        $result = [];
        foreach ($this->getFileList() as $fileInfo) {
            foreach ($needles as $needle) {
                $isFound = ($sensitive) ?
                    (strpos($fileInfo['filename'], $needle, $offset) !== false) :
                    (stripos($fileInfo['filename'], $needle, $offset) !== false);
                if ($isFound) {
                    $result[] = $this->returnFile($fileInfo);
                }
            }
        }
        return $result;
    }

    public function returnFile(array $fileInfo)
    {
        return new File(
            $this->directory.$fileInfo['filename'],
            null,
            $fileInfo
        );
    }
}
