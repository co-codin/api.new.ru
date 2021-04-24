<?php


namespace Modules\Currency\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Modules\Currency\Http\Requests\CurrencyCreateRequest;
use Modules\Currency\Repositories\CurrencyRepository;
use Modules\Currency\Services\CurrencyStorage;

class CurrencyController extends Controller
{
    public function __construct(
        protected CurrencyRepository $currencyRepository,
        protected CurrencyStorage $currencyStorage
    ){}

    public function store(CurrencyCreateRequest $request)
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
