<?php

namespace Modules\Product\Indices;

use Modules\Product\Http\Resources\Index\ProductSearchResource;
use Modules\Product\Models\Product;
use Modules\Product\Repositories\ProductRepository;
use Modules\Search\Services\BaseIndex;

class ProductIndex extends BaseIndex
{
    public function name(): string
    {
        return (new Product())->getSearchIndex();
    }

    public function repository(): string
    {
        return ProductRepository::class;
    }

    public function resource(): string
    {
        return ProductSearchResource::class;
    }

    public function settings(): array
    {
        return [
            'number_of_shards' => 2,
            'number_of_replicas' => 0,
            'index' => [
                'max_ngram_diff' => 10
            ],
        ];
    }

    protected function analysis()
    {
        return [];
    }

    public function mappings(): array
    {
        return [
            'properties' => [
                'id' => [
                    'type' => 'integer',
                ],
                'article' => [
                    'type' => 'keyword',
                ],
                'name' => [
                    'type' => 'keyword',
                ],
                'slug' => [
                    'type' => 'keyword',
                ],
                'status' => [
                    'properties' => [
                        'id' => [
                            'type' => 'byte',
                        ],
                        'name' => [
                            'type' => 'keyword',
                        ],
                        'slug' => [
                            'type' => 'keyword',
                        ],
                    ],
                ],
                'warranty' => [
                    'type' => 'integer',
                ],
                'group' => [
                    'type' => 'float',
                ],
                'popular_score' => [
                    'type' => 'byte',
                ],
                'availability_sort_value' => [
                    'type' => 'byte',
                ],
                'brand' => [
                    'properties' => [
                        'id' => [
                            'type' => 'integer',
                        ],
                        'slug' => [
                            'type' => 'keyword',
                        ],
                        'country_id' => [
                            'type' => 'integer',
                        ],
                        'name' => [
                            'type' => 'keyword',
                        ],
                        'status' => [
                            'properties' => [
                                'id' => [
                                    'type' => 'byte',
                                ],
                                'name' => [
                                    'type' => 'keyword',
                                ],
                                'slug' => [
                                    'type' => 'keyword',
                                ],
                            ],
                        ],
                    ],
                ],
                'category' => [
                    'properties' => [
                        'id' => [
                            'type' => 'integer',
                        ],
                        'name' => [
                            'type' => 'keyword',
                        ],
                        'slug' => [
                            'type' => 'keyword',
                        ],
                        'status' => [
                            'properties' => [
                                'id' => [
                                    'type' => 'byte',
                                ],
                                'name' => [
                                    'type' => 'keyword',
                                ],
                                'slug' => [
                                    'type' => 'keyword',
                                ],
                            ],
                        ],
                    ],
                ],
                'categories' => [
                    'type' => 'nested',
                    'properties' => [
                        'id' => [
                            'type' => 'integer',
                        ],
                        'slug' => [
                            'type' => 'keyword',
                        ],
                        'name' => [
                            'type' => 'keyword',
                        ],
                        'status' => [
                            'properties' => [
                                'id' => [
                                    'type' => 'byte',
                                ],
                                'name' => [
                                    'type' => 'keyword',
                                ],
                                'slug' => [
                                    'type' => 'keyword',
                                ],
                            ],
                        ],
                    ],
                ],
                'properties' => [
                    'type' => 'nested',
                    'properties' => [
                        'id' => [
                            'type' => 'integer',
                        ],
                        'name' => [
                            'type' => 'keyword',
                        ],
                        'value' => [
                            'type' => 'keyword',
                        ],
                        'value_numeric' => [
                            'type' => 'float',
                        ],
                    ],
                ],
                'variations' => [
                    'type' => 'nested',
                    'properties' => [
                        'id' => [
                            'type' => 'integer',
                        ],
                        'price' => [
                            'type' => 'long',
                        ],
                        'previous_price' => [
                            'type' => 'long',
                        ],
                        'is_enabled' => [
                            'type' => 'boolean',
                        ],
                        'availability' => [
                            'type' => 'byte',
                        ],
                        'price_in_rub' => [
                            'type' => 'long',
                        ],
                        'is_price_visible' => [
                            'type' => 'byte',
                        ],
                        'is_hot' => [
                            'type' => 'byte',
                        ],
                        'availability_sort_value' => [
                            'type' => 'byte',
                        ],
                        'facets' => [
                            'type' => 'nested',
                            'properties' => [
                                'name' => [
                                    'type' => 'keyword',
                                ],
                                'value' => [
                                    'type' => 'keyword',
                                ],
                                'aggregation' => [
                                    'type' => 'keyword',
                                ],
                            ],
                        ],
                        'numeric_facets' => [
                            'type' => 'nested',
                            'properties' => [
                                'name' => [
                                    'type' => 'keyword',
                                ],
                                'value' => [
                                    'type' => 'float',
                                ],
                            ],
                        ],
                    ],
                ],
                'facets' => [
                    'type' => 'nested',
                    'properties' => [
                        'name' => [
                            'type' => 'keyword',
                        ],
                        'aggregation' => [
                            'type' => 'keyword',
                        ],
                        'value' => [
                            'type' => 'keyword',
                        ],
                        'label' => [
                            'type' => 'keyword',
                        ],
                    ],
                ],
                'numeric_facets' => [
                    'type' => 'nested',
                    'properties' => [
                        'name' => [
                            'type' => 'keyword',
                        ],
                        'value' => [
                            'type' => 'float',
                        ],
                    ],
                ],
            ],
        ];
    }

}
