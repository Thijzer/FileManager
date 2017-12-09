<?php

namespace FileManager\Client;

class FtpClient
{
    private $connection;
    private $transferMode;

    public function __construct(FtpConnection $connection)
    {
        $this->connection = $connection->getConnection();
        $this->transferMode = $connection->getTransferMode();
    }

    public function changeDirectory(string $directory)
    {
        @ftp_chdir($this->connection, $directory);
    }

    public function parentDirectory()
    {
        @ftp_cdup($this->connection);
    }

    public function getDirectory()
    {
        return @ftp_pwd($this->connection);
    }

    public function createDirectory(string $directory)
    {
        @ftp_mkdir($this->connection, $directory);
    }

    public function removeDirectory(string $directory)
    {
        @ftp_rmdir($this->connection, $directory);
    }

    public function listDirectory(string $directory)
    {
        $result = @ftp_nlist($this->connection, $directory);

        if ($result === false) {
            throw new \Exception('Unable to list directory');
        }

        asort($result);

        return $result;
    }

    public function rawListDirectory($parameters, $recursive = false)
    {
        @ftp_rawlist($this->connection, $parameters, $recursive);
    }

    public function deleteFile(string $path)
    {
        @ftp_delete($this->connection, $path);
    }

    public function getFilesize($remoteFile)
    {
        return @ftp_size($this->connection, $remoteFile);
    }

    public function renameFile($currentName, $newName)
    {
        @ftp_rename($this->connection, $currentName, $newName);
    }

    public function getFile($localFile, $remoteFile, int $resumePosition = 0)
    {
        @ftp_get($this->connection, $localFile, $remoteFile, $this->transferMode, $resumePosition);
    }

    public function putFile($remoteFile, $localFile, int $startPosition = 0)
    {
        @ftp_put($this->connection, $remoteFile, $localFile, $this->transferMode, $startPosition);
    }
//
//    public function modifiedTime($remoteFile, $format = null)
//    {
//        $time = ftp_mdtm($this->connection, $remoteFile);
//
//        if ($time !== -1 && $format !== null) {
//            return date($format, $time);
//        }
//    }
//
//    public function fget($handle, $remoteFile, int $resumePosition = 0)
//    {
//        @ftp_fget($this->connection, $handle, $remoteFile, $this->transfermode, $resumePosition);
//    }
//
//    public function fput($remoteFile, $handle, int $startPosition = 0)
//    {
//        @ftp_fput($this->connection, $remoteFile, $handle, $this->transfermode, $startPosition);
//    }
//
//    public function getOption($option)
//    {
//        switch ($option) {
//            case FtpClientFactory::TIMEOUT_SEC:
//            case FtpClientFactory::AUTOSEEK:
//                return @ftp_get_option($this->connection, $option);
//                break;
//            default:
//                throw new \Exception('Unsupported option');
//                break;
//        }
//    }
//
//    public function setOption($option, $value)
//    {
//        switch ($option) {
//            case FtpClientFactory::TIMEOUT_SEC:
//                if ($value <= 0) {
//                    throw new \Exception('Timeout value must be greater than zero');
//                }
//                break;
//            case FtpClientFactory::AUTOSEEK:
//                if (!is_bool($value)) {
//                    throw new \Exception('Autoseek value must be boolean');
//                }
//                break;
//            default:
//                throw new \Exception('Unsupported option');
//                break;
//        }
//
//        @ftp_set_option($this->connection, $option, $value);
//    }
//
//    public function allocate($filesize)
//    {
//        @ftp_alloc($this->connection, $filesize);
//    }
//
//    public function chmod($mode, $filename)
//    {
//        @ftp_chmod($this->connection, $mode, $filename);
//    }
//
//    public function exec($command)
//    {
//        @ftp_exec($this->connection, $command);
//    }
}
