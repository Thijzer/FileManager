<?php

namespace FileManager\Client;

class FtpConnection
{
    private $resource;
    private $transferMode;

    public function __construct($resource, int $transferMode)
    {
        $this->setTransferMode($transferMode);
        $this->resource = $resource;
    }

    public function getConnection()
    {
        return $this->resource;
    }

    public function closeConnection()
    {
        @ftp_close($this->resource);
        $this->resource = null;
    }

    public function setTransferMode(int $transferMode)
    {
        if (!\in_array($transferMode, [FTP_BINARY, FTP_ASCII], true)) {
            return;
        }
        $this->transferMode = $transferMode;
    }

    public function getTransferMode()
    {
        return $this->transferMode;
    }

    public function __destruct()
    {
        $this->closeConnection();
    }
}
