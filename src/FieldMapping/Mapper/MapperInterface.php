<?php

namespace Kiboko\Component\FieldMapping\Mapper;

use Doctrine\Common\Collections\Collection;

/**
 * Defines the interface of a mapper
 *
 * @author    Julien Sanchez <julien@akeneo.com>
 * @copyright 2014 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
interface MapperInterface
{
    /**
     * Get mapper identifier
     * @param string $rootIdentifier
     *
     * @return string
     */
    public function getIdentifier($rootIdentifier);

    /**
     * Get mapping
     *
     * @return Collection
     */
    public function getMapping();

    /**
     * Set mapping
     *
     * @param array $mapping
     */
    public function setMapping(array $mapping);

    /**
     * Get all targets
     *
     * @return array
     */
    public function getAllTargets();

    /**
     * Get all sources
     *
     * @return array
     */
    public function getAllSources();

    /**
     * Get mapper priority
     *
     * @return int
     */
    public function getPriority();

    /**
     * Is the mapper valid ?
     *
     * @return boolean
     */
    public function isValid();
}
