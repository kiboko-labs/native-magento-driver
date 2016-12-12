<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\Mapper\InMemory;

use Kiboko\Component\AkeneoToMagentoMapper\Exception\InvalidArgumentException;
use Kiboko\Component\AkeneoToMagentoMapper\Mapper\EntityTypeCodeMapperInterface;
use Kiboko\Component\AkeneoToMagentoMapper\Mapper\EntityTypeMapperInterface;
use Kiboko\Component\MagentoORM\Repository\EntityTypeRepositoryInterface;

class EntityTypeMapper implements EntityTypeMapperInterface
{
    /**
     * @var EntityTypeCodeMapperInterface
     */
    private $decorated;

    /**
     * @var EntityTypeRepositoryInterface
     */
    private $entityTypeRepository;

    /**
     * @var array
     */
    private $mapping = [];

    /**
     * @var array
     */
    private $unitOfWork = [];

    /**
     * @param EntityTypeCodeMapperInterface $decorated
     * @param EntityTypeRepositoryInterface $entityTypeRepository
     */
    public function __construct(
        EntityTypeCodeMapperInterface $decorated,
        EntityTypeRepositoryInterface $entityTypeRepository
    ) {
        $this->decorated = $decorated;
        $this->entityTypeRepository = $entityTypeRepository;
    }

    /**
     * @param string $akeneoCode
     * @return int
     */
    public function map($akeneoCode)
    {
        if (!is_string($akeneoCode)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Expecting string type for argument #1, found %s.',
                    is_object($akeneoCode) ? get_class($akeneoCode) : gettype($akeneoCode)
                )
            );
        }

        if (!isset($this->mapping) || !is_array($this->mapping)) {
            $this->mapping = [];
        }

        if (isset($this->mapping[$akeneoCode])) {
            return $this->mapping[$akeneoCode];
        }

        $identifier = $this->decorated->map($akeneoCode);
        if (!$identifier) {
            return;
        }

        $result = $this->entityTypeRepository->findOneByCode($identifier);

        if (!$result) {
            return;
        }

        $this->mapping[$akeneoCode] = (int) $result->getId();

        return $this->mapping[$akeneoCode];
    }

    /**
     * @param string $akeneoCode
     * @param int $magentoIdentifier
     */
    public function persist($akeneoCode, $magentoIdentifier)
    {
        if (isset($this->mapping[$akeneoCode]) || isset($this->unitOfWork[$akeneoCode])) {
            $this->unitOfWork[$akeneoCode] = $magentoIdentifier;
            return;
        }

        $result = $this->entityTypeRepository->findOneById($magentoIdentifier);
        if (!$result) {
            return;
        }

        $this->unitOfWork[$akeneoCode] = $magentoIdentifier;
        $this->decorated->persist($akeneoCode, $result->getCode());
    }

    public function flush()
    {
        $this->mapping = array_merge(
            $this->mapping,
            $this->unitOfWork
        );

        $this->unitOfWork = [];
        $this->decorated->flush();
    }
}
