<?php

namespace spec\Luni\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Luni\Component\MagentoDriver\Factory\AttributeValueFactoryInterface;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeValueQueryBuilderInterface;
use Luni\Component\MagentoDriver\Repository\AttributeRepositoryInterface;
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
        $this->shouldHaveType('Luni\Component\MagentoDriver\Repository\Doctrine\ProductAttributeValueRepository');
    }
}
