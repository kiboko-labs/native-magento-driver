<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\Mapper\Persistent;

use Kiboko\Component\AkeneoToMagentoMapper\Mapper\AttributeOptionMapperInterface;
use Kiboko\Component\AkeneoToMagentoMapper\Mapper\IdentifiableInterface;
use Kiboko\Component\AkeneoToMagentoMapper\Mapper\IdentifiableTrait;
use Kiboko\Component\AkeneoToMagentoMapper\Persister\AttributeOptionPersisterInterface;
use Kiboko\Component\AkeneoToMagentoMapper\Repository\AttributeOptionRepositoryInterface;

class AttributeOptionMapper implements AttributeOptionMapperInterface, IdentifiableInterface
{
    use IdentifiableTrait;

    /**
     * @var AttributeOptionRepositoryInterface
     */
    private $repository;

    /**
     * @var AttributeOptionPersisterInterface
     */
    private $persister;

    /**
     * @var AttributeOptionMapperInterface
     */
    private $secondLevelMapper;

    /**
     * @param AttributeOptionRepositoryInterface $repository
     * @param AttributeOptionPersisterInterface  $persister
     * @param AttributeOptionMapperInterface     $secondLevelMapper
     */
    public function __construct(
        AttributeOptionRepositoryInterface $repository,
        AttributeOptionPersisterInterface $persister,
        AttributeOptionMapperInterface $secondLevelMapper = null
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
