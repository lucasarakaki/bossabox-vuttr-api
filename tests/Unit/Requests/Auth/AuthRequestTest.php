<?php

declare(strict_types = 1);

namespace Tests\Unit\Requests\Auth;

use App\Http\Requests\Auth\AuthRequest;
use Tests\TestCase;

class AuthRequestTest extends TestCase
{
    public function test_authorize_returns_true(): void
    {
        $request = new AuthRequest();

        $this->assertTrue($request->authorize());
    }

    public function test_rules_are_correct(): void
    {
        $request = new AuthRequest();

        $this->assertEquals([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], $request->rules());
    }

    public function test_messages_are_correct(): void
    {
        $request = new AuthRequest();

        $this->assertEquals([
            'email.required' => 'The email field is required.',
            'email.email'    => 'Please enter a valid email address.',
            'password.required' => 'The password field is required.',
        ], $request->messages());
    }
}
