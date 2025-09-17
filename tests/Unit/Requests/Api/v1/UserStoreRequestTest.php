<?php

declare(strict_types = 1);

namespace Tests\Unit\Requests\Api\v1;

use App\Http\Requests\Api\v1\UserStoreRequest;
use Tests\TestCase;

class UserStoreRequestTest extends TestCase
{
    public function test_authorize_returns_true(): void
    {
        $request = new UserStoreRequest();

        $this->assertTrue($request->authorize());
    }

    public function test_rules_are_correct(): void
    {
        $request = new UserStoreRequest();

        $this->assertEquals([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'unique:users', 'email', 'max:255'],
            'password' => ['required', 'confirmed', 'min:6', 'max:16'],
        ], $request->rules());
    }

    public function test_messages_are_correct(): void
    {
        $request = new UserStoreRequest();

        $this->assertEquals([
            'name.required' => 'The name field is required.',
            'name.string'   => 'The name must be a valid text.',
            'name.max'      => 'The name may not be greater than 255 characters.',

            'email.required' => 'The email field is required.',
            'email.unique'   => 'This email address is already registered.',
            'email.email'    => 'Please provide a valid email address.',
            'email.max'      => 'The email may not be greater than 255 characters.',

            'password.required'  => 'The password field is required.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.min'       => 'The password must be at least 6 characters long.',
            'password.max'       => 'The password may not be greater than 16 characters.',
        ], $request->messages());
    }
}
