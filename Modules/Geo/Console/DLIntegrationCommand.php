<?php

namespace Modules\Geo\Console;

use App\Enums\Status;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Modules\Geo\Database\Seeders\Data\GeoData;
use Modules\Geo\Enums\OrderPointType;
use Modules\Geo\Models\City;
use Modules\Geo\Models\OrderPoint;

class DLIntegrationCommand extends Command
{
    protected $signature = 'dl:integrate';

    protected $description = 'Интеграция с деловой линии.';

    protected $places;

    protected $terminals;

    public function handle()
    {
        $this->downloadPlaces();
        $this->downloadTerminals();
        $this->truncateOrderPoint();

        foreach ($this->terminals as $city) {
            $cityModel = $this->getCity($city);

            foreach ($city['terminals']['terminal'] as $terminal) {
                $cityModel->orderPoints()->create([
                    'address' => $terminal['fullAddress'],
                    'coordinate' => [
                        'lat' => (float) $terminal['latitude'],
                        'long' => (float) $terminal['longitude'],
                    ],
                    'phone' => $terminal['mainPhone'] ?? null,
                    'email' => $terminal['mail'],
                    'timetable' => $this->parseTimeTable($terminal['worktables']['worktable'][0]),
                    'type' => OrderPointType::ORDER_POINT,
                    'status' => Status::ACTIVE,
                ]);
            }
        }
    }

    protected function downloadPlaces()
    {
        $response = app(Client::class)->post(config('services.dl.place_url'), [
            'json' => [
                'appKey' => config('services.dl.token')
            ]
        ]);

        $data = json_decode($response->getBody());

        file_put_contents(storage_path('app/places.csv'), file_get_contents($data->url));

        $this->places = $this->transformPlaces();
    }

    protected function transformPlaces()
    {
        $places = array_map('str_getcsv', file(storage_path('app/places.csv'), FILE_SKIP_EMPTY_LINES));
        $keys = array_shift($places);

        foreach ($places as $i => $row) {
            $places[$i] = array_combine($keys, $row);
        }

        return collect($places)->keyBy('cityID');
    }

    protected function truncateOrderPoint()
    {
        OrderPoint::query()->where('type', OrderPointType::ORDER_POINT)->delete();
    }

    protected function downloadTerminals()
    {
        $response = app(Client::class)->post(config('services.dl.terminal_url'), [
            'json' => [
                'appKey' => config('services.dl.token')
            ]
        ]);

        $data = json_decode($response->getBody());

        file_put_contents(storage_path('app/terminals.json'), file_get_contents($data->url));

        $this->terminals = json_decode(file_get_contents(storage_path('app/terminals.json')), true)['city'];
    }

    protected function parseTimeTable(array $timetable) : array
    {
        $weekDays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

        return collect($timetable)
            ->only($weekDays)
            ->map(function($day) {
                return explode("-", $day);
            })
            ->map(function($day) {
                return [
                    'start' => Arr::get($day, 0),
                    'finish' => Arr::get($day, 1),
                ];
            })
            ->toArray();
    }

    protected function getCity($city)
    {
        $regionName = $this->places->get($city['cityID'])['regname'];

        $regions = collect(GeoData::getRegionData());
        $region = $regions->where('name_with_type', '=', $regionName)->first();

        return City::query()->firstOrCreate([
            ['region_name_with_type', '=', $regionName],
            ['city_name', '=', $city['name']]
        ], [
            'region_name' => $region['name'],
            'region_name_with_type' => $region['name_with_type'],
            'iso' => $region['iso'],
            'federal_district' => $region['federal_district'],
            'city_name' => $city['name'],
            'coordinate' => [
                'lat' => (float) $city['latitude'],
                'long' => (float) $city['longitude'],
            ],
            'status' => Status::ACTIVE,
        ]);
    }
}
