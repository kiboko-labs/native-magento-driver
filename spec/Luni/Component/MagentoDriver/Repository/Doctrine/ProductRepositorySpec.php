<?php

namespace spec\Luni\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Luni\Component\MagentoDriver\Factory\ProductFactoryInterface;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\ProductQueryBuilderInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProductRepositorySpec extends ObjectBehavior
{
    function it_is_initializable(
        Connection $connection,
        ProductQueryBuilderInterface $queryBuilder,
        ProductFactoryInterface $productFactory
    ) {
        $this->beConstructedWith($connection, $queryBuilder, $productFactory);
        $this->shouldHaveType('Luni\Component\MagentoDriver\Repository\Doctrine\ProductRepository');
    }
}
