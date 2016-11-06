<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\Mapper\Persistent;

use Kiboko\Component\AkeneoToMagentoMapper\Mapper\AttributeMapperInterface;
use Kiboko\Component\AkeneoToMagentoMapper\Persister\AttributePersisterInterface;
use Kiboko\Component\AkeneoToMagentoMapper\Repository\AttributeRepositoryInterface;

class AttributeMapper implements AttributeMapperInterface
{
    /**
     * @var AttributeRepositoryInterface
     */
    private $repository;

    /**
     * @var AttributePersisterInterface
     */
    private $persister;

    /**
     * @var AttributeMapperInterface
     */
    private $secondLevelMapper;

    /**
     * @param AttributeRepositoryInterface $repository
     * @param AttributePersisterInterface  $persister
     * @param AttributeMapperInterface     $secondLevelMapper
     */
    public function __construct(
        AttributeRepositoryInterface $repository,
        AttributePersisterInterface $persister,
        AttributeMapperInterface $secondLevelMapper = null
    ) {
        $this->repository = $repository;
        $this->persister = $persister;
        $this->secondLevelMapper = $secondLevelMapper;
    }

    /**
     * @param string $code
     *
     * @return int
     */
    public function map($code)
    {
        if (null !== $this->secondLevelMapper &&
            null !== ($mapped = $this->secondLevelMapper->map($code))
        ) {
            return $mapped;
        }

        return $this->repository->findOneByCode($code);
    }

    /**
     * @param string $code
     * @param int    $identifier
     */
    public function persist($code, $identifier)
    {
        $this->secondLevelMapper->persist($code, $identifier);
        $this->persister->persist($code, $identifier);
    }

    public function flush()
    {
        $this->secondLevelMapper->flush();
        $this->persister->flush();
    }
}
