<?php

namespace Yeganemehr\LaravelSupport\Tests\Http\Requests\HasExtraRules;

use Illuminate\Routing\Controller;

class DummyController extends Controller
{
    public function __invoke(DummyFormRequest $request)
    {
        return response()->json($request->validated());
    }
}
