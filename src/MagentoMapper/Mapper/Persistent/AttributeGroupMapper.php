<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoMapper\Mapper\Persistent;

use Kiboko\Component\MagentoMapper\Mapper\AttributeGroupMapperInterface;
use Kiboko\Component\MagentoMapper\Persister\AttributeGroupPersisterInterface;
use Kiboko\Component\MagentoMapper\Repository\AttributeGroupRepositoryInterface;

class AttributeGroupMapper implements AttributeGroupMapperInterface
{
    /**
     * @var AttributeGroupRepositoryInterface
     */
    private $repository;

    /**
     * @var AttributeGroupPersisterInterface
     */
    private $persister;

    /**
     * @var AttributeGroupMapperInterface
     */
    private $secondLevelMapper;

    /**
     * @param AttributeGroupRepositoryInterface $repository
     * @param AttributeGroupPersisterInterface $persister
     * @param AttributeGroupMapperInterface $secondLevelMapper
     */
    public function __construct(
        AttributeGroupRepositoryInterface $repository,
        AttributeGroupPersisterInterface $persister,
        AttributeGroupMapperInterface $secondLevelMapper = null
    ) {
        $this->repository = $repository;
        $this->persister = $persister;
        $this->secondLevelMapper = $secondLevelMapper;
    }

    /**
     * @param string $groupCode
     * @param string $familyCode
     * @return int
     */
    public function map($groupCode, $familyCode)
    {
        if (null !== $this->secondLevelMapper &&
            null !== ($mapped = $this->secondLevelMapper->map($groupCode, $familyCode))
        ) {
            return $mapped;
        }

        return $this->repository->findOneByCode($groupCode, $familyCode);
    }

    /**
     * @param string $groupCode
     * @param string $familyCode
     * @param int $identifier
     */
    public function persist($groupCode, $familyCode, $identifier)
    {
        $this->secondLevelMapper->persist($groupCode, $familyCode, $identifier);
        $this->persister->persist($groupCode, $familyCode, $identifier);
    }

    /**
     * @return void
     */
    public function flush()
    {
        $this->secondLevelMapper->flush();
        $this->persister->flush();
    }
}
