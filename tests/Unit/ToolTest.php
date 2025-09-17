<?php

namespace Tests\Unit;

use App\Models\Tool;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ToolTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_tool(): void
    {
        $tool = Tool::factory()->create();

        $this->assertDatabaseHas('tools', [
            'id' => $tool->id,
        ]);
    }
}
