<?php

namespace FileManager\Client;

class FtpClient
{
    const ASCII = FTP_ASCII;
    const BINARY = FTP_BINARY;

    const TIMEOUT_SEC = FTP_TIMEOUT_SEC;
    const AUTOSEEK = FTP_AUTOSEEK;

    private $binary = false;
    private $connection;
    private $ssl;
    private $port;
    private $timeout;

    public function __construct(bool $ssl = false, int $port = 21, int $timeout = 90)
    {
        if (!extension_loaded('ftp')) {
            throw new \Exception('FTP extension is not loaded!');
        }
        $this->ssl = $ssl;
        $this->port = $port;
        $this->timeout = $timeout;
    }

    public function connect(FtpConnection $connection, bool $passiveMode = false)
    {
        $this->connection = $this->ssl ?
            @ftp_ssl_connect($connection->getHost(), $this->port, $this->timeout) :
            @ftp_connect($connection->getHost(), $this->port, $this->timeout);

        if ($this->connection == null) {
            throw new \Exception('Unable to connect');
        }

        $result = @ftp_login($this->connection, $connection->getUsername(), $connection->getPassword());

        if ($result === false) {
            throw new \Exception('Login incorrect');
        }

        if ($passiveMode) {
            $result = ftp_pasv($this->connection, true);
            if ($result === false) {
                throw new \Exception('Unable to change passive mode');
            }
        }
    }

    public function enableBinaryMode()
    {
        $this->binary = true;
    }

    public function getMode()
    {
        return $this->binary ? FTPClient::BINARY : FTPClient::ASCII;
    }

    public function changeDirectory($directory)
    {
        @ftp_chdir($this->connection, $directory);
    }

    public function parentDirectory()
    {
        @ftp_cdup($this->connection);
    }

    public function getDirectory()
    {
        $result = @ftp_pwd($this->connection);

        if ($result === false) {
            throw new \Exception('Unable to get directory name');
        }

        return $result;
    }

    public function createDirectory($directory)
    {
        @ftp_mkdir($this->connection, $directory);
    }

    public function removeDirectory($directory)
    {
        @ftp_rmdir($this->connection, $directory);
    }

    public function listDirectory($directory)
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

    public function delete($path)
    {
        @ftp_delete($this->connection, $path);
    }

    public function size($remoteFile)
    {
        return @ftp_size($this->connection, $remoteFile);
    }

    public function modifiedTime($remoteFile, $format = null)
    {
        $time = ftp_mdtm($this->connection, $remoteFile);

        if ($time !== -1 && $format !== null) {
            return date($format, $time);
        }
    }

    public function rename($currentName, $newName)
    {
        @ftp_rename($this->connection, $currentName, $newName);
    }

    public function get($localFile, $remoteFile, int $resumePosition = 0)
    {
        @ftp_get($this->connection, $localFile, $remoteFile, $this->getMode(), $resumePosition);
    }

    public function put($remoteFile, $localFile, int $startPosition = 0)
    {
        @ftp_put($this->connection, $remoteFile, $localFile, $this->getMode(), $startPosition);
    }

    public function fget($handle, $remoteFile, int $resumePosition = 0)
    {
        @ftp_fget($this->connection, $handle, $remoteFile, $this->getMode(), $resumePosition);
    }

    public function fput($remoteFile, $handle, int $startPosition = 0)
    {
        @ftp_fput($this->connection, $remoteFile, $handle, $this->getMode(), $startPosition);
    }

    public function getOption($option)
    {
        switch ($option) {
            case FTPClient::TIMEOUT_SEC:
            case FTPClient::AUTOSEEK:
                return @ftp_get_option($this->connection, $option);
                break;
            default:
                throw new \Exception('Unsupported option');
                break;
        }
    }

    public function setOption($option, $value)
    {
        switch ($option) {
            case FTPClient::TIMEOUT_SEC:
                if ($value <= 0) {
                    throw new \Exception('Timeout value must be greater than zero');
                }
                break;
            case FTPClient::AUTOSEEK:
                if (!is_bool($value)) {
                    throw new \Exception('Autoseek value must be boolean');
                }
                break;
            default:
                throw new \Exception('Unsupported option');
                break;
        }

        @ftp_set_option($this->connection, $option, $value);
    }

    public function allocate($filesize)
    {
        @ftp_alloc($this->connection, $filesize);
    }

    public function chmod($mode, $filename)
    {
        @ftp_chmod($this->connection, $mode, $filename);
    }

    public function exec($command)
    {
        @ftp_exec($this->connection, $command);
    }

    public function closeConnection()
    {
        @ftp_close($this->connection);
    }

    public function __destruct()
    {
        $this->closeConnection();
    }
}
