<?php

namespace Kiboko\Component\MagentoMapper\Mapper\Persistent;

use Kiboko\Component\MagentoMapper\Mapper\AttributeOptionMapperInterface;
use Kiboko\Component\MagentoMapper\Persister\AttributeOptionPersisterInterface;
use Kiboko\Component\MagentoMapper\Repository\AttributeOptionRepositoryInterface;

class AttributeOptionMapper implements AttributeOptionMapperInterface
{
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
     * @param AttributeOptionPersisterInterface $persister
     * @param AttributeOptionMapperInterface $secondLevelMapper
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
     * @return int
     */
    public function map($code)
    {
        if (null !== $this->secondLevelMapper &&
            null !== ($mapped = $this->secondLevelMapper->map($code))
        ) {
            return $mapped;
        }

        return (int) $this->repository->findOneByCode($code);
    }

    /**
     * @param string $code
     * @param int $identifier
     */
    public function persist($code, $identifier)
    {
        $this->secondLevelMapper->persist($code, $identifier);
        $this->persister->persist($code, $identifier);
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
