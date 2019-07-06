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

/**
 * @author Thijs De Paepe <thijs.dp@gmail.com>
 */
class File extends \SPLFileInfo
{
    private $filePath;
    private $fileContent;

    public function __construct(FilePath $filePath)
    {
        parent::__construct($filePath->getPath());

        $this->filePath = $filePath;
        $this->fileContent = new FileContent($this);
    }

    public function getPath(): string
    {
        return $this->filePath->getPath();
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