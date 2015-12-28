<?php

namespace Luni\Component\MagentoDriver\Filesystem;


use Doctrine\Common\Collections\Collection;
use League\Flysystem\Adapter\Ftp;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemInterface;

class StandardFileMover
    implements FileMoverInterface
{
    public function move(
        FilesystemInterface $source,
        FilesystemInterface $destination,
        Collection $pathList
    ) {
        /** @var \SplFileInfo $path */
        foreach ($pathList as $path) {
            if (($stream = $source->readStream($path)) === false) {
                continue;
            }
            $destination->putStream($path, $stream);
        }
    }
}