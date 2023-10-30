<?php

namespace Yeganemehr\LaravelSupport\Tests\Http\Requests\HasExtraRules;

use Illuminate\Foundation\Http\FormRequest;
use Yeganemehr\LaravelSupport\Http\Requests\HasExtraRules;

class DummyFormRequest extends FormRequest
{
    use HasExtraRules;

    public function defaultRules(): array
    {
        return [
            'default' => ['required', 'string'],
        ];
    }
}
