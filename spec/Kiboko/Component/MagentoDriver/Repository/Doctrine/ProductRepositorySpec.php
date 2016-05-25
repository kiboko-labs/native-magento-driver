<?php

namespace spec\Kiboko\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Factory\ProductFactoryInterface;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\ProductQueryBuilderInterface;
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
        $this->shouldHaveType('Kiboko\Component\MagentoDriver\Repository\Doctrine\ProductRepository');
    }
}
