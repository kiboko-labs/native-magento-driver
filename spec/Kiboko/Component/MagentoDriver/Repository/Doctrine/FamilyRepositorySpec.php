<?php

namespace spec\Kiboko\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Factory\FamilyFactoryInterface;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\FamilyQueryBuilderInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FamilyRepositorySpec extends ObjectBehavior
{
    function it_is_initializable(
        Connection $connection,
        FamilyQueryBuilderInterface $queryBuilder,
        FamilyFactoryInterface $familyFactory
    ) {
        $this->beConstructedWith($connection, $queryBuilder, $familyFactory);
        $this->shouldHaveType('Kiboko\Component\MagentoDriver\Repository\Doctrine\FamilyRepository');
    }
}
