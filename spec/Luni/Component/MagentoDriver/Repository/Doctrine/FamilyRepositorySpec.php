<?php

namespace spec\Luni\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Luni\Component\MagentoDriver\Factory\FamilyFactoryInterface;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\FamilyQueryBuilderInterface;
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
        $this->shouldHaveType('Luni\Component\MagentoDriver\Repository\Doctrine\FamilyRepository');
    }
}
