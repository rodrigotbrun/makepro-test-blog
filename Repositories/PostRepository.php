<?php

namespace Blog\Repositories;

use Blog\Models\Category;

interface PostRepository {

    public function listAll();

    public function listAllPaginated($perPage = 15);

    public function listAllForCategory(Category $category);

    public function listAllPaginatedForCategory(Category $category, $perPage = 15);

    public function get($id);

    public function create(array $attributes = []);

    public function delete($id);

    public function update($id, array $attributes = []);

}