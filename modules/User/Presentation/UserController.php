<?php
namespace Modules\User\Presentation;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\User\Application\Mappers\UserMapper;
use Modules\User\Application\UseCases\Commands\StoreUserCommand;
use Modules\User\Application\UseCases\Commands\UpdateUserCommand;
use Modules\Shared\Presentation\BaseController;
use Modules\User\Application\UseCases\Commands\DeleteUserCommand;
use Modules\User\Application\UseCases\Queries\GetUsersQuery;
use Modules\User\Presentation\Requests\StoreUserRequest;
use Modules\User\Presentation\Requests\UpdateUserRequest;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UserController extends BaseController
{
    /**
     * @param Request $request
     * @param GetUsersQuery $getUsersQuery
     * @return JsonResponse
     */
    public function get(Request $request, GetUsersQuery $getUsersQuery): JsonResponse
    {
        try {
            $userDTO = UserMapper::requestToDTO($request);
            $users   = $getUsersQuery->handle($userDTO);

            return $this->sendResponse(
                result: UserMapper::entitiesToResponseUserDTOs($users),
            );

        } catch (Throwable $e) {

            return $this->handleException($e);
        }
    }

    /**
     * @param StoreUserRequest $request
     * @param StoreUserCommand $storeUserCommand
     *
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request, StoreUserCommand $storeUserCommand): JsonResponse
    {
        try {
            $userDTO    = UserMapper::requestToDTO($request);
            $userEntity = $storeUserCommand->handle($userDTO);

            return $this->sendResponse(
                result: UserMapper::entityToResponseUserDTO($userEntity)->toArray(),
                httpCode: Response::HTTP_CREATED,
            );

        } catch (Throwable $e) {

            return $this->handleException($e);
        }
    }

    /**
     * @param int $id
     * @param UpdateUserRequest $request
     * @param UpdateUserCommand $updateUserCommand
     *
     * @return JsonResponse
     */
    public function update(int $id, UpdateUserRequest $request, UpdateUserCommand $updateUserCommand): JsonResponse
    {
        try {
            $userDTO    = UserMapper::requestToDTO($request);
            $userEntity = $updateUserCommand->handle($userDTO);
            return $this->sendResponse(
                UserMapper::entityToResponseUserDTO($userEntity)->toArray()
            );

        } catch (Throwable $e) {

            return $this->handleException($e);
        }
    }

    /**
     * @param int $id
     * @param DeleteUserCommand $deleteUserCommand
     *
     * @return JsonResponse
     */
    public function destroy(int $id, DeleteUserCommand $deleteUserCommand): JsonResponse
    {
        try {
            $deleteUserCommand->handle($id);
            return $this->sendResponse(httpCode: Response::HTTP_NO_CONTENT);

        } catch (Throwable $e) {

            return $this->handleException($e);
        }
    }
}
