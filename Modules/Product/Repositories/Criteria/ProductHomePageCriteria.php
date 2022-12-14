<?php

namespace Modules\Product\Repositories\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ProductHomePageCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return $model
            ->select([
                'id', 'name', 'article', 'image', 'slug', 'group_id', 'brand_id', 'stock_type_id',
            ])
            ->with([
                'brand' => function ($query) {
                    $query->addSelect('id', 'name');
                }])
            ->with([
                'stockType' => function ($query) {
                    $query->addSelect('id', 'value');
                }
            ])
            ->with([
                'category' => function ($query) {
                    $query->addSelect('id', 'name');
                }
            ])
            ->with([
                'images' => function ($query) {
                    $query->addSelect('imageable_id', 'image');
                }
            ])
            ->with([
                'productReviews' => function ($query) {
                    $query->addSelect('product_id', 'ratings');
                }
            ])
            ->with([
                'productVariations' => function ($query) {
                    $query
                        ->addSelect(
                            'id', 'name', 'price', 'previous_price', 'is_price_visible',
                            'currency_id'
                        )
                        ->with([
                            'currency' => function ($query) {
                                $query->addSelect('id', 'rate');
                            }
                        ])
                    ;
                }
            ])
            ->withCount('productAnswers AS productAnswerCount')
            ->withCount('productReviews AS productReviewCount')
            ;
    }
}
