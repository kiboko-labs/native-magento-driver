<?php

namespace Kiboko\Component\MagentoMapper\Mapper\InMemory;

use Kiboko\Component\MagentoMapper\Mapper\FamilyMapperInterface;

class FamilyMapper implements FamilyMapperInterface
{
    use InMemoryMapperTrait;

    protected $mapping = [
        'bag' => 47,
        'bandeau_bra' => 41,
        'bath_robe' => 31,
        'belt' => 45,
        'blouse' => 19,
        'bow_tie' => 53,
        'boxer' => 35,
        'bra' => 40,
        'briefs' => 34,
        'cap' => 85,
        'chocolate' => 48,
        'clutch_bag' => 60,
        'coat' => 49,
        'corseted_dress' => 29,
        'costumes' => 73,
        'dress' => 28,
        'garter_belt' => 76,
        'glasses_case' => 81,
        'hooded_sweater' => 21,
        'jacket' => 24,
        'jeans' => 12,
        'jewel' => 61,
        'leather_goods' => 57,
        'legging' => 26,
        'nightdress' => 58,
        'panties' => 33,
        'pantyhose' => 43,
        'polo_shirt' => 17,
        'pushup_bra' => 77,
        'scarf' => 46,
        'shirt' => 25,
        'shoes' => 59,
        'shorts' => 38,
        'shorty' => 36,
        'skirt' => 27,
        'sockets' => 32,
        'stocking' => 44,
        'string' => 39,
        'suit' => 30,
        'sweater' => 22,
        'sweat_shirt' => 23,
        'swimsuit_bandeau_bra' => 62,
        'swimsuit_boxer' => 65,
        'swimsuit_bra' => 63,
        'swimsuit_briefs' => 64,
        'swimsuit_one_piece' => 72,
        'swimsuit_panties' => 66,
        'swimsuit_short' => 67,
        'swimsuit_shorty' => 68,
        'swimsuit_string' => 69,
        'swimsuit_tanga' => 70,
        'swimsuit_triangle_bra' => 71,
        'tablet_case' => 80,
        'tanga' => 37,
        'tank_top' => 16,
        'tie' => 52,
        'top' => 14,
        'triangle_bra' => 42,
        'trousers' => 13,
        'tshirt' => 18,
        'tunic' => 54,
        'turtleneck_shirt' => 15,
        'vest' => 20,
        'wallet' => 82,
    ];

    /**
     * @param array|null $mapping
     */
    public function __construct(
        array $mapping = null
    ) {
        if ($mapping !== null) {
            $this->mapping = $mapping;
        }
    }
}
