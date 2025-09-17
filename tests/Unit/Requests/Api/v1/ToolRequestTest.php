<?php

declare(strict_types = 1);

namespace Tests\Unit\Requests\Api\v1;

use App\Http\Requests\Api\v1\ToolRequest;
use App\Models\Tool;
use Illuminate\Validation\Rule;
use Tests\TestCase;

class ToolRequestTest extends TestCase
{
    public function test_authorize_returns_true(): void
    {
        $request = new ToolRequest();

        $this->assertTrue($request->authorize());
    }

    public function test_rules_for_creating_a_tool(): void
    {
        $request = new ToolRequest();

        $expected = [
            'title'       => ['required', 'string', 'max:255'],
            'link'        => ['required', 'url:http,https', 'max:2048', Rule::unique('tools')->ignore(null)],
            'description' => ['nullable', 'string'],
            'tags'        => ['nullable', 'array'],
        ];

        $this->assertEquals($expected, $request->rules());
    }

    public function test_rules_for_updating_a_tool(): void
    {
        $tool = Tool::factory()->create();
        $request = new ToolRequest();
        $request->setRouteResolver(function () use ($tool) {
            $route = new \Illuminate\Routing\Route('PUT', 'api/v1/tools/{tool}', []);
            $route->bind(new \Illuminate\Http\Request());
            $route->setParameter('tool', $tool);
            return $route;
        });

        $expected = [
            'title'       => ['required', 'string', 'max:255'],
            'link'        => ['required', 'url:http,https', 'max:2048', Rule::unique('tools')->ignore($tool)],
            'description' => ['nullable', 'string'],
            'tags'        => ['nullable', 'array'],
        ];

        $this->assertEquals($expected, $request->rules());
    }

    public function test_messages_are_correct(): void
    {
        $request = new ToolRequest();

        $this->assertEquals([
            'title.required' => 'The title field is required.',
            'title.string'   => 'The title must be a valid string.',
            'title.max'      => 'The title may not be greater than 255 characters.',

            'link.required' => 'The link field is required.',
            'link.url'      => 'The link must be a valid URL starting with http or https.',
            'link.unique'   => 'This link has already been taken.',
            'link.max'      => 'The link may not be greater than 2048 characters.',

            'description.string' => 'The description must be a valid string.',

            'tags.array' => 'The tags must be an array of values.',
        ], $request->messages());
    }
}
