<?php

namespace Yeganemehr\LaravelSupport\Tests\Http\Requests;

use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase;
use Yeganemehr\LaravelSupport\Tests\Http\Requests\HasExtraRules\DummyController;
use Yeganemehr\LaravelSupport\Tests\Http\Requests\HasExtraRules\DummyFormRequest;

class HasExtraRulesTest extends TestCase
{
    use WithWorkbench;

    public function test()
    {
        Route::post('/test/yeganemehr/laravel-support/http/requests/has-extra-rules', DummyController::class);

        $this->app->resolving(DummyFormRequest::class, function (DummyFormRequest $request) {
            $request->addExtraRule('extra', ['required', 'numeric']);
        });

        $this->postJson(url('/test/yeganemehr/laravel-support/http/requests/has-extra-rules'), [
            'default' => 'test',
            'extra' => 123,
        ])
            ->assertOk()
            ->assertJson([
                'default' => 'test',
                'extra' => '123',
            ]);

        $this->postJson(url('/test/yeganemehr/laravel-support/http/requests/has-extra-rules'), [
            'default' => 'test',
            'extra' => 'non-numeric',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('extra');

        $this->postJson(url('/test/yeganemehr/laravel-support/http/requests/has-extra-rules'), [
            'default' => ['test'],
            'extra' => 123,
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('default');
    }
}
