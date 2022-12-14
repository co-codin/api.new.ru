<?php

namespace Modules\Client\Http\Controllers;

use App\Http\Controllers\Controller;

class ClientAuthController extends Controller
{
    public function logout()
    {
        auth('client')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
