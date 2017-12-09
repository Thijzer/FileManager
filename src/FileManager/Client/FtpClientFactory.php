<?php

namespace FileManager\Client;

class FtpClientFactory
{
    const TIMEOUT_SEC = FTP_TIMEOUT_SEC;
    const AUTOSEEK = FTP_AUTOSEEK;

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
        $this->transferMode = FTP_ASCII;
    }

    public function createConnection(FtpAccount $account, bool $passiveMode = false, int $transferMode) : FtpClient
    {
        $connection = $this->ssl ?
            @ftp_ssl_connect($account->getHost(), $this->port, $this->timeout) :
            @ftp_connect($account->getHost(), $this->port, $this->timeout)
        ;

        if ($connection === null) {
            throw new \Exception('Unable to connect');
        }

        if (!@ftp_login($connection, $account->getUsername(), $account->getPassword())) {
            throw new \Exception('Login incorrect');
        }

        if ($passiveMode && !ftp_pasv($connection, true)) {
            throw new \Exception('Unable to change passive mode');
        }

        return new FtpClient(new FtpConnection($connection, $transferMode));
    }
}
