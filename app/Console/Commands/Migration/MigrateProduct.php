<?php

namespace App\Console\Commands\Migration;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Product\Models\Product;

class MigrateProduct extends Command
{
    protected $signature = 'migrate:product';

    protected $description = 'Migrate product';

    public function handle()
    {
        Model::unguard();

        $oldProducts = DB::connection('old_medeq_mysql')->table('products')->get();

        foreach ($oldProducts as $oldProduct) {
            Product::query()->insert(
                $this->transform($oldProduct)
            );
        }
    }

    protected function transform($item)
    {
        $data = [
            'id' => $item->id,
            'name' => $item->title,
            'slug' => $item->slug,
            'brand_id' => $item->brand_id,
            'status' => $item->status,
            'booklet' => !is_null($item->booklet) ? ltrim($item->booklet, "/") : null,
            'video' => $item->video,
            'image' => !is_null($item->image) ? ltrim($item->image, "/"): null,
            'is_in_home' => $item->in_home === 1,
            'short_description' => $item->short_description,
            'full_description' => $item->full_description,
            'assigned_by_id' => 1,
//            'warranty' => \Arr::random([12, 24, 36, 48, 60, 18, null]),
            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at,
        ];

        if ($item->status == 4) {
            $data = array_merge($data, [
                'deleted_at' => Carbon::now(),
                'status' => 2,
            ]);
        }

        return $data;
    }
}
