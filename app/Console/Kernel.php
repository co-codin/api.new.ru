<?php

namespace App\Console;

use App\Console\Commands\GenerateSitemapCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Modules\Currency\Console\CurrencyParseCommand;
use Modules\Export\Console\ExportAllFeedsCommand;
use Modules\Export\Services\ExportScheduler;
use Modules\Product\Console\ProductAnalogSearchCommand;
use Modules\Product\Console\ProductVariationLinkCommand;
use Modules\Search\Console\SearchReindexCommand;

class Kernel extends ConsoleKernel
{
    public function __construct(
        Application $app,
        Dispatcher $events
    ) {
        parent::__construct($app, $events);
    }

    protected $commands = [
        CurrencyParseCommand::class,
        SearchReindexCommand::class,
        ProductAnalogSearchCommand::class,
        ProductVariationLinkCommand::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('telescope:prune --hours=744')->daily();

        $schedule->command('horizon:snapshot')->everyFiveMinutes();

        $schedule->command(CurrencyParseCommand::class)
            ->description('Парсинг курсов валют ЦБ РФ')
            ->twiceDaily()
            ->after(function () {
                \Artisan::call(ExportAllFeedsCommand::class);
            });

        app(ExportScheduler::class)
            ->scheduleExportCommands($schedule);

        // генерируем карту сайта
        $schedule->command(GenerateSitemapCommand::class)
            ->description('Генерация карты сайта')
            ->weekly();

        // переиндексируем базу товаров
        $schedule->command(SearchReindexCommand::class)
            ->description('Переиндексация товаров в ElasticSearch')
            ->twiceDaily();

        // ищем аналоги товаров
        $schedule->command(ProductAnalogSearchCommand::class)
            ->description('Поиск аналогов товаров')
            ->daily();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
