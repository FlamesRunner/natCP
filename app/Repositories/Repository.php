<?php

namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class Repository
{
    protected $model;

    public function getAll()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(Request $request)
    {
        $model = $this->model->create($request->all());
        return $model;
    }

    public function update($id,Request $request)
    {
        $model = $this->model->findOrFail($id);
        $model->update($request->all());
        return $model;
    }

    public function delete($id)
    {
        $this->model->destroy($id);
    }
}