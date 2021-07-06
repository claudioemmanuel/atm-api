<?php

namespace App\Repositories;

use App\Models\User;
use Carbon\Carbon;

class UserRepository
{
    /**
     * The user model implementation.
     * 
     * @var User;
     */
    protected $model;

    /**
     * UserRepository constructor.
     *
     * @param App\Models\User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * Get all users
     *
     * @return mixed
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Create new user
     *
     * @param array $request
     * @return App\Models\User
     */
    public function create(array $request)
    {
        return $this->model->create($request);
    }

    /**
     * Find by id
     *
     * @param int $id
     * @return App\Models\User
     */
    public function findById(int $id)
    {
        return $this->model->where('id', $id)->first();
    }

    /**
     * Find by cpf 
     *
     * @param string $cpf
     * @return App\Models\User
     */
    public function findByCpf(string $cpf)
    {
        return $this->model->where('cpf', $cpf)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param array $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function updateById(array $request, int $id)
    {
        if (isset($request['birth_date'])) {
            $request['birth_date'] = Carbon::createFromFormat('d/m/Y', $request['birth_date'], 'America/Sao_Paulo')->format('Y-m-d');
        }

        $object = $this->model->find($id);

        if ($object) {

            $object->fill($request)->save();

            return $object;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function deleteById(int $id)
    {
        $object = $this->model->find($id);

        if ($object) {

            $object->delete();

            return $object;
        }
    }
}
