<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Broker;

use Kiboko\Component\MagentoORM\Matcher\AttributeMatcherInterface;
use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use Kiboko\Component\MagentoORM\Repository\ProductAttributeValueRepositoryInterface;

interface ProductAttributeValueRepositoryBrokerInterface
{
    /**
     * @param ProductAttributeValueRepositoryInterface $repository
     * @param AttributeMatcherInterface           $matcher
     */
    public function addRepository(
        ProductAttributeValueRepositoryInterface $repository,
        AttributeMatcherInterface $matcher
    );

    /**
     * @return \Generator|ProductAttributeValueRepositoryInterface[]
     */
    public function walkRepositoryList();

    /**
     * @param AttributeInterface $attribute
     *
     * @return ProductAttributeValueRepositoryInterface|null
     */
    public function findFor(AttributeInterface $attribute);
}
