<?php

namespace Modules\Page\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Page\Http\Resources\PageResource;
use Modules\Page\Repositories\PageRepository;

class PageController extends Controller
{
    public function __construct(
        protected PageRepository $pageRepository
    ) {}

    public function index()
    {
        $pages = $this->pageRepository->jsonPaginate();

        return PageResource::collection($pages);
    }

    public function show(string $slug)
    {
        $page = $this->pageRepository->findBySlug($slug);

        return new PageResource($page);
    }
}
