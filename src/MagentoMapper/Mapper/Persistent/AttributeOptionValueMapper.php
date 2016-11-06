<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

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
     * @param AttributeOptionValuePersisterInterface  $persister
     * @param AttributeOptionValueMapperInterface     $secondLevelMapper
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
     * @param string $locale
     *
     * @return int
     */
    public function map($code, $locale)
    {
        if (null !== $this->secondLevelMapper &&
            null !== ($mapped = $this->secondLevelMapper->map($code, $locale))
        ) {
            return $mapped;
        }

        return $this->repository->findOneByCodeAndLocale($code, $locale);
    }

    /**
     * @param string $optionCode
     * @param string $locale
     * @param int    $identifier
     */
    public function persist($optionCode, $locale, $identifier)
    {
        $this->secondLevelMapper->persist($optionCode, $locale, $identifier);
        $this->persister->persist($optionCode, $locale, $identifier);
    }

    public function flush()
    {
        $this->secondLevelMapper->flush();
        $this->persister->flush();
    }
}
