<?php

namespace Yeganemehr\LaravelSupport\Http\Requests;

trait HasExtraRules
{
    public array $extraRules = [];

    public function rules(): array
    {
        $defaultRules = [];
        if (method_exists($this, 'defaultRules')) {
            $defaultRules = $this->defaultRules();
        }

        return array_merge_recursive($defaultRules, $this->extraRules);
    }

    public function addExtraRule(string $field, array|string $validationRules): static
    {
        $this->extraRules[$field] = $validationRules;

        return $this;
    }
}
