<?php

namespace Modules\Achievement\Repositories;

use App\Repositories\BaseRepository;
use Modules\Achievement\Models\Achievement;
use Modules\Achievement\Repositories\Criteria\ExportRequestCriteria;

class AchievementRepository extends BaseRepository
{
    public function model()
    {
        return Achievement::class;
    }

    public function boot()
    {
        $this->pushCriteria(ExportRequestCriteria::class);
    }
}
