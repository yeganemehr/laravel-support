# HasExtraRules

This trait enable your `FormRequest` to accept new rules from other packages.
Let's see an example:

You have a `UserStoreRequest` to administrators can make users manually:
```php
<?php

namespace Yeganemehr\UserManagement\Http\Requests;

use Yeganemehr\UserManagement\Enums\UserStatus;
use Yeganemehr\UserManagement\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Yeganemehr\LaravelSupport\Http\Requests\HasExtraRules;

class UserStoreRequest extends FormRequest
{
	// Add this
	use HasExtraRules;

    public function authorize(): bool
    {
        return $this->user()->can('store', User::class);
    }

	// this renamed from `rules()` to `defaultRules()`
    public function defaultRules(): array
    {
        return [
            'name' => ['required', 'string'],
            'type_id' => ['required', 'exists:Yeganemehr\UserManagement\Models\UserType,id'],
            'status' => ['required', Rule::enum(UserStatus::class)],
            'username' => ['required', 'string'],
            'password*' => ['required', 'string'],
        ];
    }
}
```

Now in other package, lets say `emails-for-users` we add another rule to this request and validate `email` field.

In service provider of `emails-for-users` package:
```php
<?php

namespace Yeganemehr\EmailsForUsers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Yeganemehr\UserManagement\Http\Requests\UserStoreRequest;

class ServiceProvider extends BaseServiceProvider
{
	public function boot()
    {
        $this->app->resolving(UserStoreRequest::class, function ($request) {
            $request->addExtraRule('email', [
				'required',
				'email',
				'unique:Yeganemehr\UserManagement\Models\User,email'
			]);
        });
    }
}
```