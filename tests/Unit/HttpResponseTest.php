<?php

declare(strict_types = 1);

namespace Tests\Unit;

use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class HttpResponseTest extends TestCase
{
    use HttpResponse;

    public function test_success_response(): void
    {
        $response = $this->success('Test success', 200, ['data' => 'test']);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'message' => 'Test success',
                'status'  => 200,
                'data'    => ['data' => 'test'],
            ]),
            $response->getContent(),
        );
    }

    public function test_error_response(): void
    {
        $response = $this->error('Test error', 500, ['error' => 'test']);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(500, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'message' => 'Test error',
                'status'  => 500,
                'errors'  => ['error' => 'test'],
                'data'    => [],
            ]),
            $response->getContent(),
        );
    }
}
