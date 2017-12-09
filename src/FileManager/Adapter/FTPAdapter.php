<?php

namespace FileManager\Adapter;

use FileManager\Client\FtpClient;
use FileManager\File;
use FileManager\FileManagerInterface;

class FTPAdapter extends AbstractAdapter implements FileManagerInterface
{
    /** @var FtpClient */
    private $ftpClient;
    private $directory;

    public function __construct($directory, array $settings)
    {
        $directory = rtrim($directory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $this->directory = $directory;
        $this->connect($settings);
    }

    private function connect($settings)
    {
        $settings;
        $this->ftpClient = new FtpClient();
        $this->ftpClient->connect();
        $this->ftpClient->login();
    }

    public function addFile(File $file)
    {
        $this->ftpClient->put();
    }

    public function move(File $file, $location)
    {
        // TODO: Implement move() method.
    }

    public function persist(FileManagerInterface $index = null)
    {
        $this->sync($index);
        $this->close();
    }

    public function removeFile(File $file)
    {
        $this->ftpClient->delete($file->getFullPath());
    }

    public function addDirectory($directoryName)
    {
        $this->ftpClient->createDirectory($directoryName);
    }

    public function removeDirectory($directoryName)
    {
        $this->ftpClient->removeDirectory($directoryName);
    }

    public function getFileList()
    {
        $this->ftpClient->listDirectory($this->directory);
    }

    public function getFile($filename)
    {
        $this->ftpClient->fget();
    }

    public function rename(File $file, $newFilename)
    {
        $this->ftpClient->rename($file->getFilename(), $newFilename . $file->getExtension());
    }

    public function isDirectory($directoryName)
    {
        true === @$this->setDirectory($directoryName);
    }
}
