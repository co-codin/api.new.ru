<?php


namespace Modules\Search\Services;


use App\Enums\Status;
use Illuminate\Database\Eloquent\Collection;
use Modules\Category\Models\Category;
use Modules\Category\Repositories\CategoryRepository;

/**
 * @method Category[]|Collection getEntities(string $term, int $size = 1): Collection
 */
class CategorySearchService extends SearchService
{
    public function __construct(
        protected CategoryRepository $repository
    ) {}

    /**
     * @throws \Exception
     */
    public function getLiveSearchCategories(string $term, int $size = 1): ?array
    {
        $brands = $this->getEntities($term, $size);

        return $brands->map(function (Category $category) {
            return [
                'id' => $category->id,
                'slug' => $category->slug,
                'parent_id' => $category->parent_id,
                'name' => $category->name,
                'url' => config('app.site_url') . "/store/$category->slug",
                'type' => is_null($category->parent_id) ? 'Категория' : 'Подкатегория',
            ];
        })->toArray();
    }

    protected function getQuery(string $term): array
    {
        $fields = [
            'name.with_ru_en',
            'name.without_ru_en',
            'name.shingle',
            'name.phonetic',
            'name',
        ];

        return [
            'bool' => [
                'must' => [
                    'multi_match' => [
                        'fields' => $fields,
                        'query' => $term,
                        'type' => 'most_fields',
                        'fuzziness' => 'AUTO',
                        'operator' => 'and',
                        'prefix_length' => 2,
                        'minimum_should_match' => '80%',
                    ],
                ],
                "filter" => [
                    "term" => [
                        'status.id' => Status::ACTIVE
                    ]
                ]
            ]
        ];
        return [
//            'multi_match' => [
//                'fields' => $fields,
//                'query' => $term,
//                'type' => 'most_fields',
//                'fuzziness' => 'AUTO',
//                'operator' => 'and',
//                'prefix_length' => 2,
//                'minimum_should_match' => '80%',
//            ],

//            'bool' => [
//                    'should' => [
//                        [
//                            'multi_match' => [
//                                'fields' => $fields,
//                                'query' => $term,
//                                'type' => 'most_fields',
//                                'fuzziness' => 'AUTO',
//                                'operator' => 'and',
//                                'prefix_length' => 2,
//                                'minimum_should_match' => '80%',
//                            ],
//                        ],
//                    ],
//                    'filter' => [
//                        [
//                            'term' => [
//                                'status.key' => Status::ACTIVE,
//                            ],
//                        ],
////                        [
////                            'term' => [
////                                'products_exist' => ProductSearchStatus::Exist,
////                            ],
////                        ]
//                    ],
//                    'minimum_should_match' => 1
//                ],
        ];
    }
}
