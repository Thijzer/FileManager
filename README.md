File Manager
============

This project is for demo purposes only.

$adapter = new FtpAdapter($settings);
$fm = new FileManager(/path, $adapter);

$fm->addFile();

$fm->addFiles();

$fm->getfile();

$fm->getfiles();

$fm->move();

$fm->copy();

$fm->presist();

$fm->fileCount();


FileManager -> indexer -> adapter (FTP/local)

object passed is File

file read write writeStream


action copy a folder from fm A to fm B

fm A local

f = getFiles / index
removeFiles / command

Fm B ftp

addFiles(f);

persist;
