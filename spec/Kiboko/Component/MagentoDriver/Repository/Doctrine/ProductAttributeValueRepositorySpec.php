<?php

namespace spec\Kiboko\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Factory\AttributeValueFactoryInterface;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeValueQueryBuilderInterface;
use Kiboko\Component\MagentoDriver\Repository\AttributeRepositoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProductAttributeValueRepositorySpec extends ObjectBehavior
{
    function it_is_initializable(
        Connection $connection,
        ProductAttributeValueQueryBuilderInterface $queryBuilder,
        AttributeRepositoryInterface $attributeRepository,
        AttributeValueFactoryInterface $valueFactory
    ) {
        $this->beConstructedWith($connection, $queryBuilder, $attributeRepository, $valueFactory);
        $this->shouldHaveType('Kiboko\Component\MagentoDriver\Repository\Doctrine\ProductAttributeValueRepository');
    }
}
