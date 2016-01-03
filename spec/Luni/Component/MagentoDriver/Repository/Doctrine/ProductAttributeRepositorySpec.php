<?php

namespace spec\Luni\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Luni\Component\MagentoDriver\Factory\ProductAttributeValueFactoryInterface;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\ProductAttributeQueryBuilderInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProductAttributeRepositorySpec extends ObjectBehavior
{
    function it_is_initializable(
        Connection $connection,
        ProductAttributeQueryBuilderInterface $queryBuilder,
        ProductAttributeValueFactoryInterface $productAttributeValueFactory
    ) {
        $this->beConstructedWith($connection, $queryBuilder, $productAttributeValueFactory);
        $this->shouldHaveType('Luni\Component\MagentoDriver\Repository\Doctrine\ProductAttributeRepository');
    }
}
