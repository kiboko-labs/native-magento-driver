<?php

namespace Kiboko\Component\MagentoMapper\Mapper\Persistent;

use Kiboko\Component\MagentoMapper\Mapper\AttributeOptionValueMapperInterface;
use Kiboko\Component\MagentoMapper\Persister\AttributeOptionValuePersisterInterface;
use Kiboko\Component\MagentoMapper\Repository\AttributeOptionValueRepositoryInterface;

class AttributeOptionValueMapper implements AttributeOptionValueMapperInterface
{
    /**
     * @var AttributeOptionValueRepositoryInterface
     */
    private $repository;

    /**
     * @var AttributeOptionValuePersisterInterface
     */
    private $persister;

    /**
     * @var AttributeOptionValueMapperInterface
     */
    private $secondLevelMapper;

    /**
     * @param AttributeOptionValueRepositoryInterface $repository
     * @param AttributeOptionValuePersisterInterface $persister
     * @param AttributeOptionValueMapperInterface $secondLevelMapper
     */
    public function __construct(
        AttributeOptionValueRepositoryInterface $repository,
        AttributeOptionValuePersisterInterface $persister,
        AttributeOptionValueMapperInterface $secondLevelMapper = null
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

        return $this->repository->findOneByCode($code);
    }

    /**
     * @param string $optionCode
     * @param string $locale
     * @param int $identifier
     */
    public function persist($optionCode, $locale, $identifier)
    {
        $this->secondLevelMapper->persist($optionCode, $locale, $identifier);
        $this->persister->persist($optionCode, $locale, $identifier);
    }
}
