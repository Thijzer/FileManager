<?php

namespace Utils;

class FileUtils
{
    /**
     * Returns the mime Type of the File
     *
     * @return [type] [description]
     */
    public function getMimeType()
    {
        if (!$this->isfile()) {
            throw new \Exception("Error Processing Request : File content doesn't exist");
        }
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimetype = finfo_file($finfo, $this->fullPath);
        finfo_close($finfo);
        return $mimetype;
    }

    /**
     * Returns the byte size of the file
     *
     * @return string
     */
    public function getSizeInBytes()
    {
        if (!$this->isfile()) {
            throw new \Exception("Error Processing Request : File content doesn't exist");
        }
        clearstatcache(); # required
        $bytesize = filesize($this->fullPath);
        return $bytesize;
    }

    /**
     * Returns the Directory the file is stored in
     *
     * @return string
     */
    public function getDirectory()
    {
        return pathinfo($this->fullPath, PATHINFO_DIRNAME);
    }

    /**
     * Returns the Formatted File size of the File
     *
     * @param  integer $decimals the number of decimals you wish to return
     * @return string  Formatted Filesize
     */
    public function getFilesize($decimals = 2)
    {
        $bytes = $this->getSizeInBytes();
        $size = array("Bytes", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB");
        $factor = floor((strlen($bytes) - 1) / 3);
        $formattedFilesize = sprintf("%.{$decimals}f", $bytes / pow(1024, $factor));
        $formattedFilesize .= ' ' . @$size[$factor];
        return $formattedFilesize;
    }
}