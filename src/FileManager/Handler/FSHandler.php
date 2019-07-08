<?php
namespace FileManager\Handler;

use FileManager\Adapter\FSAdapter;
use FileManager\Commands\CommandRecorder;
use FileManager\Commands\CommandResolver;
use FileManager\Commands\DirAction;
use FileManager\Commands\FileAction;

class FSHandler
{
    /** @var FSAdapter */
    private $adapter;
    /** @var CommandResolver */
    private $resolver;

    public function __construct(FSAdapter $adapter, CommandResolver $resolver)
    {
        $this->adapter = $adapter;
        $this->resolver = $resolver;
    }

    public function handleAllRecordings(CommandRecorder $commandRecorder): void
    {
        foreach ($commandRecorder->getRecordedCommands() as $command) {
            switch (true) {
                // FILE
                case $command->getAction() === FileAction::ADD:
                    $this->adapter->addFile($command->getAsset());
                    break;
                case $command->getAction() === FileAction::GET_FILE:
                    $file = $this->adapter->getFile($command->getAsset());
                    $this->resolver->addCommands($command, $file);
                    break;
                case $command->getAction() === FileAction::RENAME:
                    $this->adapter->renameFile($command->getAsset(), $command->getResolution());
                    break;
                case $command->getAction() === FileAction::IS_FILE:
                    $this->resolver->addCommands($command, $this->adapter->isFile($command->getAsset()));
                    break;
                case $command->getAction() === FileAction::COPY:
                    $this->adapter->copyFile($command->getAsset(), $command->getResolution());
                    break;
                case $command->getAction() === FileAction::DELETE:
                    $this->adapter->removeFile($command->getAsset());
                    break;
                case $command->getAction() === FileAction::UPDATE:
                    //$this->adapter->updateFile($command->getAsset());
                    break;

                // DIR
                case $command->getAction() === DirAction::SCAN_DIR;
                    $this->resolver->addCommands($command, $this->adapter->findFiles($command->getAsset()));
                    break;

                case $command->getAction() === DirAction::READ_DIR:
                    $this->adapter->getDirectoryList($command->getAsset());
                    break;

            }
        }
    }
}