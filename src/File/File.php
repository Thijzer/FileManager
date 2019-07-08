<?php

/*
 * This file is part of the File Manager.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * issues
 * - getContent should never point to memory but to its content location
 */

namespace File;

use FileManager\Adapter\FSAdapter;

/**
 * @author Thijs De Paepe <thijs.dp@gmail.com>
 */
class File extends \SPLFileInfo
{
    private $filePath;
    private $fileContent;

    public function __construct(FilePath $filePath)
    {
        parent::__construct($filePath->getAbsolutePath());

        $this->filePath = $filePath;
        $this->fileContent = new FileContent($this);
    }

    // todo we need to change the passing of static construction of SPlFileinfo
    // so we can get more info like / absolute path / relative path / filename / date time / size / type
    // cheap operation without I/O calls should be collected
    // expensive operations should be done by the adapter
    public static function createFromSpfFileInfo(\SplFileInfo $fileInfo, string $rootDirectory = null): self
    {
        $relativePath = str_replace($rootDirectory, '',  $fileInfo->getRealPath());

        return new self(new FilePath($relativePath, $rootDirectory));
    }

    public static function createAdaptableFile(FSAdapter $adapter, FilePath $filePath, string $rootDirectory = null): self
    {
        $relativePath = str_replace($rootDirectory, '',  $filePath->getPath());

        $file = new self(new FilePath($relativePath, $rootDirectory));
        $file->getFileContent()->setAdapter($adapter);

        return $file;
    }

    public function getPath(): string
    {
        return $this->filePath->getPath();
    }

    public function getName(): string
    {
        return $this->getFilename();
    }

    public function getContent(): string
    {
        return $this->fileContent->getContent();
    }

    public function getFilePath(): FilePath
    {
        return $this->filePath;
    }

    public function getFileContent(): FileContent
    {
        return $this->fileContent;
    }
}