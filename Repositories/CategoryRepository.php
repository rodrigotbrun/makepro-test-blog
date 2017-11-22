<?php

namespace Blog\Repositories;

interface CategoryRepository {

    public function listAll();

    public function listAllPaginated($perPage = 15);

    public function get($id);

    public function create(array $attributes = []);

    public function delete($id);

    public function update($id, array $attributes = []);

}