<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\Mapper\Persistent;

use Kiboko\Component\AkeneoToMagentoMapper\Mapper\FamilyMapperInterface;
use Kiboko\Component\AkeneoToMagentoMapper\Persister\FamilyPersisterInterface;
use Kiboko\Component\AkeneoToMagentoMapper\Repository\FamilyRepositoryInterface;

class FamilyMapper implements FamilyMapperInterface
{
    /**
     * @var FamilyRepositoryInterface
     */
    private $repository;

    /**
     * @var FamilyPersisterInterface
     */
    private $persister;

    /**
     * @var FamilyMapperInterface
     */
    private $secondLevelMapper;

    /**
     * @param FamilyRepositoryInterface $repository
     * @param FamilyPersisterInterface  $persister
     * @param FamilyMapperInterface     $secondLevelMapper
     */
    public function __construct(
        FamilyRepositoryInterface $repository,
        FamilyPersisterInterface $persister,
        FamilyMapperInterface $secondLevelMapper = null
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
