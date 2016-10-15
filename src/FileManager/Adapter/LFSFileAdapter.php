<?php

namespace FileManager\Adapter;

class LFSFileAdapter extends \SPLFileInfo implements FileAdapter
{
    /**
     * Get File Content
     *
     * @return string file content
     */
    public function read()
    {
        return !$this->content ? @file_get_contents($this->fullPath) : $this->content;
    }

    /** @return string */
    public function getRealName()
    {
        return rtrim($this->getBasename($this->getExtension()), '.');
    }

    public function write($content)
    {
        $fullPath = $this->id->getFullPath();
        try {
            $localFile = fopen($this->fullPath, 'w+');
            fwrite($localFile, $this->getContent());
            fclose($localFile);
        } catch (\Exception $e) {
            throw new \Exception("Error Saving File " . $this->fullPath, $e);
        }
    }

    public function getDirectory()
    {
        return pathinfo($this->fullPath, PATHINFO_DIRNAME);
    }

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

    public function metaInfo()
    {
        // TODO: Implement metaInfo() method.
    }
}
