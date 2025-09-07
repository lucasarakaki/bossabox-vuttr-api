<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\UserStoreRequest;
use App\Http\Requests\Api\v1\UserUpdateRequest;
use App\Http\Resources\Api\v1\UserCollection;
use App\Http\Resources\Api\v1\UserResource;
use App\Models\User;
use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    use HttpResponse;

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->success('Get all users', 200, new UserCollection(User::all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserStoreRequest $userStoreRequest
     *
     * @return JsonResponse
     */
    public function store(UserStoreRequest $userStoreRequest): JsonResponse
    {
        $data = $userStoreRequest->validated();

        $user = User::create($data);

        return $this->success('Created a user', 201, new UserResource($user));
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
        return $this->success('Get a user', 200, new UserResource(User::findOrFail($id)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserUpdateRequest $userUpdateRequest
     * @param string            $id
     *
     * @return JsonResponse
     */
    public function update(UserUpdateRequest $userUpdateRequest, string $id): JsonResponse
    {
        $data = $userUpdateRequest->validated();

        $user = User::find($id);

        if ($user === null) {
            return $this->error("User with id {$id} not found", 404);
        }

        $user->update($data);

        return $this->success('Updated a user', 200, new UserResource($user));
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
        $user = User::find($id);

        if ($user === null) {
            return $this->error("User with id {$id} not found", 404);
        }

        if ($user->delete() === false) {
            return $this->error("Couldn't delete the user with id {$id}", 400, []);
        }

        return $this->success('User deleted', 200, ['id' => $id, 'deleted' => true]);
    }
}
