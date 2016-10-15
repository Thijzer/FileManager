<?php

namespace FileManager\Adapter;

abstract class AbstractAdapter
{
    public function removeFiles(array $files)
    {
        foreach ($files as $file) {
            $this->removeFile($file);
        }
    }

    public function copy(File $file, $location)
    {
        $filename = $file->getRealName().'-copy'.$file->getExtension();
        $this->addFile(new File($location.$filename));
    }

    public function addFiles(array $files)
    {
        foreach ($files as $file) {
            $this->addFile($file);
        }
    }

    protected function hardSync(Indexer $index)
    {
        foreach ($index->getAddedFiles() as $file) {
            $this->addFile($file);
        }
        foreach ($index->getRemoveFiles() as $file) {
            $this->removeFile($file);
        }
        foreach ($index->getRemovedDirectories() as $directory) {
            $this->removeDirectory($directory);
        }
        foreach ($index->getAddedDirectories() as $directory) {
            $this->addDirectory($directory);
        }
    }
}
