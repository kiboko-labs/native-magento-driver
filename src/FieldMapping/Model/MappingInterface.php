<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\FieldMapping\Model;

interface MappingInterface
{
    /**
     * Set identifier
     *
     * @return string
     */
    public function getId();

    /**
     * Get source
     *
     * @return string
     */
    public function getSource();

    /**
     * Set target
     *
     * @return string
     */
    public function getTarget();
}
