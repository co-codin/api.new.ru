<?php

namespace Modules\News\Events;

use Illuminate\Queue\SerializesModels;
use Modules\News\Models\News;

class NewsViewed
{
    use SerializesModels;

    public $news_single;

    public function __construct(?News $news_single)
    {
        $this->news_single = $news_single;
    }
}
