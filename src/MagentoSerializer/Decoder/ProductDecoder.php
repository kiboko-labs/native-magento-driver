<?php

namespace Luni\Component\MagentoSerializer\Decoder;

use Luni\Component\MagentoDriver\Repository\ProductAttributeRepositoryInterface;
use Luni\Component\MagentoMapper\Repository\CategoryRepositoryInterface;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

class ProductDecoder implements DecoderInterface
{
    private $headers;
    private $headersCount;
    private $productAttributeRepository;
    private $categoryMapperRepository;

    public function __construct(
        array $headers,
        ProductAttributeRepositoryInterface $productAttributeRepository,
        CategoryRepositoryInterface $categoryMapperRepository
    ) {
        $this->headers = $headers;
        $this->headersCount = count($headers);
        $this->productAttributeRepository = $productAttributeRepository;
        $this->categoryMapperRepository = $categoryMapperRepository;
    }

    public function decode($data, $format, array $context = [])
    {
        $reader = new \SplFileObject($data, 'r');
        while (!$reader->eof()) {
            try {
                $data = $this->read($reader);

                if ($data === null) {
                    continue;
                }
            } catch (\Exception $e) {
                file_put_contents('php://stderr', $e->getMessage());
                continue;
            }
        }
    }

    public function supportsDecoding($format)
    {
        return $format === 'csv';
    }

    public function read(\SplFileObject $reader)
    {
        $raw = $reader->fgetcsv(';', '"');

        if (count($raw) !== $this->headersCount) {
            throw new \RuntimeException(sprintf('Ignored line : ["%s"]', implode('", "', $raw)));
        }

        $data = [];
        $rawData = array_combine($this->headers, $raw);

        foreach ($rawData as $field => $value) {
            if ($field === 'sku') {
                $data['sku'] = $value;
                continue;
            } elseif ($field === 'code') {
                $data['sku'] = $value;
                continue;
            } elseif ($field === 'family') {
                $data['family'] = $value;
                continue;
            }

            if (($position = strpos($field, '-')) === false) {
                $fieldName = $field;
                $options = [];
            } else {
                $fieldName = substr($field, 0, $position);
                $options = explode('-', substr($field, $position + 1));

                if (in_array('unit', $options)) {
                    continue;
                }
            }

            if (!isset($data[$fieldName])) {
                $data[$fieldName] = [];
            }

            $attribute = $this->productAttributeRepository->findOneByCode('catalog_product', $fieldName);
            if ($attribute !== null) {
                if ($attribute->getFrontendType() !== 'multiselect' &&
                    !in_array($fieldName, ['axis', 'groups', 'categories'])
                ) {
                    $finalValue = [
                        'attribute' => $fieldName,
                        'value' => $value,
                    ];
                } else {
                    $finalValue = [
                        'attribute' => $fieldName,
                        'value' => $value === '' ? [] : (strpos(',', $value) === false ? [$value] : explode(',', $value)),
                    ];
                }
            } elseif ($fieldName === 'groups') {
                $data['visibility'] = [
                    [
                        'attribute' => 'visibility',
                        'value' => 1,
                    ],
                ];

                $data['groups'] = $value === '' ? [] : (strpos(',', $value) === false ? [$value] : explode(',', $value));
                continue;
            } elseif ($fieldName === 'categories') {
                $data['categories'] = $this->categoryMapperRepository->findAllByCodes(explode(',', $value));
                continue;
            } elseif ($fieldName === 'axis') {
                $data['axis'] = $this->productAttributeRepository->findAllByCode('catalog_product', explode(',', $value));
                continue;
            } else {
                continue;
            }

            if (isset($rawData[$fieldName.'-unit'])) {
                $finalValue = array_merge(
                    $finalValue,
                    [
                        'unit' => $rawData[$fieldName.'-unit'],
                    ]
                );
            }

            $option = array_shift($options);
            if (preg_match('/^[a-z]{2,3}_[A-Z]{2}$/', $option)) {
                $finalValue = array_merge(
                    $finalValue,
                    [
                        'locale' => $option,
                    ]
                );
                $option = array_shift($options);
            }

            if ($attribute !== null &&
                $attribute->getFrontendType() === 'price' &&
                preg_match('/^[A-Z]{3}$/', $option)
            ) {
                $finalValue = array_merge(
                    $finalValue,
                    [
                        'currency' => $option,
                    ]
                );
                $option = array_shift($options);
            }

            if ($option !== null) {
                $finalValue = array_merge(
                    $finalValue,
                    [
                        'channel' => $option,
                    ]
                );
            }

            $data[$fieldName] = [
                $finalValue,
            ];
        }

        $data['options_container'] = [
            [
                'attribute' => 'options_container',
                'locale' => 'fr_FR',
                'channel' => 'ecommerce_luni',
                'value' => 'container2',
            ],
        ];

        if (!isset($data['groups'])) {
            $data['visibility'] = [
                [
                    'attribute' => 'visibility',
                    'value' => 4,
                ],
            ];
        } else {
            $data['visibility'] = [
                [
                    'attribute' => 'visibility',
                    'value' => 1,
                ],
            ];
        }

        $data['status'] = [
            [
                'attribute' => 'status',
                'value' => 1,
            ],
        ];

        $data['tax_class_id'] = [
            [
                'attribute' => 'tax_class_id',
                'value' => 2,
            ],
        ];

        $data['weight'] = [
            [
                'attribute' => 'weight',
                'value' => .1,
            ],
        ];

        return $data;
    }
}
