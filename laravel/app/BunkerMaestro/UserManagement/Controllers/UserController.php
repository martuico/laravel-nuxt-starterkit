<?php


namespace App\BunkerMaestro\UserManagement\Controllers;


use App\BunkerMaestro\Core\Controllers\ApiController;
use App\BunkerMaestro\UserManagement\Actions\CreateUser;
use App\BunkerMaestro\UserManagement\Actions\GetUserById;
use App\BunkerMaestro\UserManagement\Actions\GetUsersList;
use App\BunkerMaestro\UserManagement\Requests\StoreUserRequest;
use App\BunkerMaestro\UserManagement\Transformers\UserTransformer;
use App\Http\Requests\App\BunkerMaestro\UserManagement\Requests\UserRequest;
use Dingo\Blueprint\Annotation\Resource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @package App\BunkerMaestro\UserManagement\Controllers
 *
 * User resource representation.
 * @Resource("Users")
 */
class UserController extends ApiController
{

    /**
     * Gets the list of all the users
     * @return JsonResponse
     */
    public function index(GetUsersList $getUsersAction): Response
    {
        $page = (int)request()->input('page', 1);
        $users = $getUsersAction->handle($page);
        return $this->response->paginator($users, new usertransformer(), ['key' => 'user']);
    }

    public function store(StoreUserRequest $request, CreateUser $createUserAction)
    {
        $user = $createUserAction->handle($request->input('name'), $request->input('email'));
        return $this->item($user, new UserTransformer());
    }

    public function show(int $id, GetUserById $getUserAction)
    {
        $user = $getUserAction->handle($id);
        return $this->item($user, new UserTransformer());
    }

    protected function getResourceType(): string
    {
        return 'user';
    }
}
