<?php

namespace spec\Kiboko\Component\MagentoORM\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoORM\Factory\ProductFactoryInterface;
use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\ProductQueryBuilderInterface;
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
        $this->shouldHaveType('Kiboko\Component\MagentoORM\Repository\Doctrine\ProductRepository');
    }
}
