<?php

namespace Modules\Customer\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Customer\Http\Resources\CustomerReviewResource;
use Modules\Customer\Models\CustomerReview;
use Modules\Customer\Repositories\CustomerReviewRepository;

class CustomerReviewController extends Controller
{
    public function __construct(
        protected CustomerReviewRepository $customerReviewRepository
    ) {}

    public function index()
    {
        $customerReviews = $this->customerReviewRepository->jsonPaginate();

        return CustomerReviewResource::collection($customerReviews);
    }

    public function show(int $customerReview)
    {
        $customerReview = $this->customerReviewRepository->find($customerReview);

        return new CustomerReviewResource($customerReview);
    }
}
