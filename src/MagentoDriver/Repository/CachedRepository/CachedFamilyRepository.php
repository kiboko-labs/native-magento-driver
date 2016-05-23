<?php

namespace Kiboko\Component\MagentoDriver\Repository\CachedRepository;

use Kiboko\Component\MagentoDriver\Model\FamilyInterface;
use Kiboko\Component\MagentoDriver\Repository\FamilyRepositoryInterface;

class CachedFamilyRepository implements FamilyRepositoryInterface
{
    /**
     * @var FamilyRepositoryInterface
     */
    private $decorated;

    /**
     * @var FamilyInterface[]
     */
    private $cacheById;

    /**
     * @var FamilyInterface[]
     */
    private $cacheByName;

    /**
     * CachedFamilyRepository constructor.
     *
     * @param FamilyRepositoryInterface $familyRepository
     */
    public function __construct(FamilyRepositoryInterface $familyRepository)
    {
        $this->decorated = $familyRepository;
        $this->cacheById = [];
        $this->cacheByName = [];
    }

    /**
     * @param int $id
     *
     * @return FamilyInterface|null
     */
    public function findOneById($id)
    {
        if (isset($this->cacheById[$id])) {
            return $this->cacheById[$id];
        }

        $family = $this->decorated->findOneById($id);
        if ($family === null) {
            return;
        }

        $this->cacheById[$family->getId()] = $family;
        $this->cacheByName[$family->getLabel()] = $family;

        return $family;
    }

    /**
     * @param string $name
     *
     * @return FamilyInterface|null
     */
    public function findOneByName($name)
    {
        if (isset($this->cacheByName[$name])) {
            return $this->cacheByName[$name];
        }

        $family = $this->decorated->findOneByName($name);
        if ($family === null) {
            return;
        }

        $this->cacheById[$family->getId()] = $family;
        $this->cacheByName[$family->getLabel()] = $family;

        return $family;
    }
}
