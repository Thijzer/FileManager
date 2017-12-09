<?php

namespace FileManager\Client;

class FtpConnection
{
    private $host;
    private $username;
    private $password;

    public function __construct(
        string $host,
        string $username = 'anonymous',
        string $password = ''
    ) {
        $this->host = $host;
        $this->password = $password;
        $this->username = $username;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
}
