<?php

namespace App\Console\Commands\Migration;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Currency\Models\Currency;

class MigrateCurrency extends Command
{
    protected $signature = 'migrate:currency';

    protected $description = 'Migrate currency';

    public function handle()
    {
        Model::unguard();

        $oldCurrencies = DB::connection('old_medeq_mysql')
            ->table('currencies')
            ->get();

        foreach ($oldCurrencies as $oldCurrency) {
            Currency::query()->create(
                $this->transform($oldCurrency)
            );
        }
    }

    protected function transform($item)
    {
        return [
            'id' => $item->id,
            'name' => $item->title,
            'iso_code' => strtoupper($item->code),
            'rate' => $item->rate / 100,
            'is_main' => false,
        ];
    }
}
