<?php

namespace FileManager\Adapter;

use FileManager\Commands\CommandRecorder;
use FileManager\Commands\FileAction;
use FileManager\File;
use FileManager\FileManagerInterface;

class LFSAdapter
{
//    private $directory;
//    /** @var array */
//    private $systemFiles = ['.DS_Store', '@eaDir'];
//
//    public function getFileAdapter()
//    {
//        return new LFSFileAdapter($this->directory);
//    }

    public function addFile(File $file)
    {
        try {
            $localFile = fopen($this->fullPath, 'w+');
            fwrite($localFile, $this->getContent());
            fclose($localFile);
        } catch (\Exception $e) {
            throw new \Exception("Error Saving File ".$this->fullPath, $e);
        }
    }

//    public function addFiles(array $files)
//    {
//        foreach ($files as $file) {
//            $this->addFile($file);
//        }
//    }
//
//    public function move(File $file, $location)
//    {
//        // TODO: Implement move() method.
//    }
//
//    public function copy(File $file, $location)
//    {
//        if (!$this->isDirectory($location)) {
//            // throw
//        }
//        $filename = $file->getRealName().'-copy'.$file->getExtension();
//        $this->addFile(new File($location.$filename));
//    }
//
//    public function persist(FileCommandSet $commandSet)
//    {
//        $this->handle($commandSet);
//        $this->close();
//    }
//
//    public function scan()
//    {
//        return array_diff(array_filter(scandir($this->directory), function ($item) {
//            return !is_dir($this->directory.$item);
//        }), $this->systemFiles);
//    }
//
//    public function find(...$query)
//    {
//        // TODO: Implement find() method.
//    }
//
//    /** @return boolean */
//    public function exists($filename)
//    {
//        true === @$this->getFile($filename);
//    }
//
//    public function removeFile(File $file)
//    {
//        unlink($this->fullPath);
//    }
//
//    public function addDirectory($directoryName)
//    {
//        $this->ftpClient->createDirectory($directoryName);
//    }
//
//    public function removeDirectory($directoryName)
//    {
//        $this->ftpClient->removeDirectory($directoryName);
//    }
//
//    public function getFileList()
//    {
//        $this->ftpClient->listDirectory($this->directory);
//    }
//
//    public function getFile($filename)
//    {
//        $this->ftpClient->fget();
//    }
//
//    public function rename(File $file, $newFilename)
//    {
//        $this->ftpClient->rename($file->getFilename(), $newFilename.$file->getExtension());
//    }
//
//    public function isDirectory($directoryName)
//    {
//        true === @$this->getDirectory($directoryName);
//    }
//
//    public function getDirectoryList($directoryName = null)
//    {
//        // TODO: Implement getDirectoryList() method.
//    }
//
//    public function moveDirectory($source, $destination)
//    {
//        rename($source, $destination);
//    }
//
//    /** @return boolean */
//    public function isFile($filename)
//    {
//        // TODO: Implement isFile() method.
//    }

    public function handle(CommandRecorder $commandRecorder)
    {
        foreach ($commandRecorder->getRecordedCommands() as $command) {
            switch (true)
            {
                case $command->getAction() === FileAction::CREATE:
                    $this->addFile($command->getFile());
                    break;
            }
        }
    }
}
