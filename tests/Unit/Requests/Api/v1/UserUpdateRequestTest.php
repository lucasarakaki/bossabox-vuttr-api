<?php

declare(strict_types = 1);

namespace Tests\Unit\Requests\Api\v1;

use App\Http\Requests\Api\v1\UserUpdateRequest;
use App\Models\User;
use Illuminate\Validation\Rule;
use Tests\TestCase;

class UserUpdateRequestTest extends TestCase
{
    public function test_authorize_returns_true(): void
    {
        $request = new UserUpdateRequest();

        $this->assertTrue($request->authorize());
    }

    public function test_rules_for_updating_a_user(): void
    {
        $user = User::factory()->create();
        $request = new UserUpdateRequest();
        $request->setRouteResolver(function () use ($user) {
            $route = new \Illuminate\Routing\Route('PUT', 'api/v1/users/{user}', []);
            $route->bind(new \Illuminate\Http\Request());
            $route->setParameter('user', $user);
            return $route;
        });

        $expected = [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user)],
            'password' => ['nullable', 'confirmed', 'min:6', 'max:16'],
        ];

        $this->assertEquals($expected, $request->rules());
    }

    public function test_messages_are_correct(): void
    {
        $request = new UserUpdateRequest();

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
