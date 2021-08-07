<?php

namespace Modules\Geo\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Geo\Models\City;
use Modules\Geo\Services\SxGeo;

class GeoController extends Controller
{
    public function detectIp(Request $request)
    {
        $request->validate([
            'ip' => 'required|ip'
        ]);

        $SxGeo = new SxGeo(storage_path('app/SxGeoCity.dat', SXGEO_BATCH | SXGEO_MEMORY));

        $city = $SxGeo->getCity($request->get('ip'));

        if ($cityModel = City::query()->where('city_name', 'LIKE', "%{$city['city']['name_ru']}%")->first()) {
            return $cityModel;
        } else {
            return City::query()->where('is_default', '=', 1)->first();
        }
    }
}
