<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * Create a new controller instance.
     *
     * @param App\Repositories\UserRepository $userRepository
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display all users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            return response([
                'data'     => UserResource::collection($this->userRepository->all()),
            ], Response::HTTP_OK);
        } catch (\Exception $e) {

            return response([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Validate the request and create a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try {
            
            return response([
                'data'  => new UserResource(
                    $this->userRepository->create($request->all())
                ),
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {

            return response([
                'message'   => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $user = $this->userRepository->findById($id);

            if ($user) {

                return response([
                    'data'      => new UserResource($user),
                ], Response::HTTP_OK);
            } else {
                return response([
                    'message'   => 'Usuário não encontrado.',
                ], Response::HTTP_NOT_FOUND);
            }
        } catch (\Exception $e) {
            return response([
                'message'   => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Validate the request and update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

            $updated_user = $this->userRepository->updateById($request->all(), $id);

            if ($updated_user) {
                return response([
                    'data'     => new UserResource($updated_user),
                ], Response::HTTP_OK);
            } else {
                return response([
                    'message'   => 'Usuário não encontrado.'
                ], Response::HTTP_NOT_FOUND);
            }
        } catch (\Exception $e) {

            return response([
                'message'   => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $deleted_user = $this->userRepository->deleteById($id);

            if ($deleted_user) {
                return response([
                    'data'     => new UserResource($deleted_user),
                ], Response::HTTP_OK);
            } else {
                return response([
                    'message'   => 'Usuário não encontrado'
                ], Response::HTTP_NOT_FOUND);
            }
        } catch (\Exception $e) {

            return response([
                'message'   => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
