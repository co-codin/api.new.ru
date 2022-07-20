<?php


namespace Modules\Filter\Http\Controllers;


use App\Http\Controllers\Controller;
use Modules\Filter\Http\Resources\FilterResource;
use Modules\Filter\Models\Filter;
use Modules\Filter\Repositories\FilterRepository;

class FilterController extends Controller
{
    public function __construct(
        protected FilterRepository $filterRepository
    ) {}

    public function index()
    {
        $this->authorize('viewAny', Filter::class);

        $filters = $this->filterRepository->jsonPaginate();

        return FilterResource::collection($filters);
    }

    public function show(int $filter)
    {
        $filter = $this->filterRepository->find($filter);

        $this->authorize('view', $filter);

        return new FilterResource($filter);
    }
}
