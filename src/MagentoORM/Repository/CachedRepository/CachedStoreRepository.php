<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Repository\CachedRepository;

use Kiboko\Component\MagentoORM\Model\StoreInterface;
use Kiboko\Component\MagentoORM\Repository\StoreRepositoryInterface;

class CachedStoreRepository implements StoreRepositoryInterface
{
    /**
     * @var StoreRepositoryInterface
     */
    private $decorated;

    /**
     * @var StoreInterface[]
     */
    private $cacheById;

    /**
     * @var StoreInterface[]
     */
    private $cacheByCode;

    /**
     * CachedStoreRepository constructor.
     *
     * @param StoreRepositoryInterface $storeRepository
     */
    public function __construct(StoreRepositoryInterface $storeRepository)
    {
        $this->decorated = $storeRepository;
        $this->cacheById = [];
        $this->cacheByCode = [];
    }

    /**
     * @param int $identifier
     *
     * @return StoreInterface|null
     */
    public function findOneById($identifier)
    {
        if (isset($this->cacheById[$identifier])) {
            return $this->cacheById[$identifier];
        }

        $store = $this->decorated->findOneById($identifier);
        if ($store === null) {
            return;
        }

        $this->cacheById[$store->getId()] = $store;
        $this->cacheByCode[$store->getCode()] = $store;

        return $store;
    }

    /**
     * @param string $code
     *
     * @return StoreInterface|null
     */
    public function findOneByCode($code)
    {
        if (isset($this->cacheByCode[$code])) {
            return $this->cacheByCode[$code];
        }

        $store = $this->decorated->findOneByCode($code);
        if ($store === null) {
            return;
        }

        $this->cacheById[$store->getId()] = $store;
        $this->cacheByCode[$store->getCode()] = $store;

        return $store;
    }

    /**
     * @return StoreInterface[]|\Traversable
     */
    public function findAll()
    {
        return array_values($this->cacheById);
    }
}
