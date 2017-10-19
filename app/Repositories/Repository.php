<?php

namespace App\Repositories;


abstract class Repository
{
    protected $model;

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create($data)
    {
        $model = $this->model->create($data);
        return $model;
    }

    public function update($id,$data)
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete($id)
    {
        $this->model->destroy($id);
    }
}