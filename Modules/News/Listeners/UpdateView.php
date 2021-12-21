<?php

namespace Modules\News\Listeners;


class UpdateView
{
    public function handle($event)
    {
        $event->news_single->update([
            'view_num' => $event->news_single->view_num ? $event->news_single->view_num + 1 : 1
        ]);
    }
}
