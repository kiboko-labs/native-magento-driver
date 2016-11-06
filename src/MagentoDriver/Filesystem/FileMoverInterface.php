<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Filesystem;

use League\Flysystem\FilesystemInterface;

interface FileMoverInterface
{
    public function move(
        FilesystemInterface $source,
        FilesystemInterface $destination,
        \Traversable $pathList
    );
}
