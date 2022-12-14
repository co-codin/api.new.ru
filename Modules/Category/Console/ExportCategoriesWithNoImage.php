<?php

namespace Modules\Category\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Modules\Category\Models\Category;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ExportCategoriesWithNoImage extends Command
{
    protected $signature = 'export:categories-with-no-image';

    protected $description = 'Export categories with image url but no file';

    public function handle()
    {
        $filePath = storage_path('app/no_image_categories.csv');

        $file = fopen($filePath, 'wb');

        fputcsv($file, array('id', 'name', 'image'));

        foreach (Category::query()->whereNotNull('image')->get() as $category) {
            try {
                $response = Http::get(Storage::disk('medeq')->url($category->image));
                if ($response->status() !== 200) {
                    fputcsv($file, [$category->id, $category->name, $category->image]);
                }
            } catch (\Exception $exception) {
            }
        }

        fclose($file);

    }
}
