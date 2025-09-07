<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\ToolRequest;
use App\Http\Resources\Api\v1\ToolCollection;
use App\Http\Resources\Api\v1\ToolResource;
use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ToolController extends Controller
{
    use HttpResponse;

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $tools = Auth::user()->tools;

        return $this->success('Get all tools', 200, new ToolCollection($tools));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ToolRequest $toolRequest
     *
     * @return JsonResponse
     */
    public function store(ToolRequest $toolRequest): JsonResponse
    {
        $data = $toolRequest->validated();

        $tool = Auth::user()->tools()->create($data);

        return $this->success('Created a tool', 201, new ToolResource($tool));
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     *
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $tool = Auth::user()->tools()->find($id);

        if ($tool === null) {
            return $this->error("Tool with id {$id} not found", 404);
        }

        return $this->success('Get a tool', 200, new ToolResource($tool));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ToolRequest $toolRequest
     * @param string      $id
     *
     * @return JsonResponse
     */
    public function update(ToolRequest $toolRequest, string $id): JsonResponse
    {
        $data = $toolRequest->validated();

        $tool = Auth::user()->tools()->find($id);

        if ($tool === null) {
            return $this->error("Tool with id {$id} not found", 404);
        }

        $tool->update($data);

        return $this->success('Updated a tool', 200, new ToolResource($tool));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     *
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $tool = Auth::user()->tools()->find($id);

        if ($tool === null) {
            return $this->error("Tool with id {$id} not found", 404);
        }

        if ($tool->delete() === false) {
            return $this->error("Couldn't delete the tool with id {$id}", 400, []);
        }

        return $this->success('Deleted tool', 200, ['id' => $id, 'deleted' => true]);
    }
}
