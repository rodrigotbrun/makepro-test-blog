<?php

namespace Blog\Repositories\DataSource;

use Blog\Exceptions\CategoryNotFoundException;
use Blog\Models\Category;
use Blog\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CategoryEloquentDataSource implements CategoryRepository {

    /**
     * @var Category
     */
    private $model;

    /**
     * CategoryEloquentDataSource constructor.
     * @param Category $model
     */
    public function __construct(Category $model) {
        $this->model = $model;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|Category[]
     */
    public function listAll() {
        return $this->model->all();
    }

    /**
     * @param int $perPage
     * @return Category[]|\Illuminate\Database\Eloquent\Collection
     */
    public function listAllPaginated($perPage = 15) {
        return $this->model->paginate($perPage);
    }

    /**
     * @param $id
     * @return Category
     * @throws CategoryNotFoundException
     */
    public function get($id) {
        $model = $this->model->find($id);

        if (empty($model))
            throw new CategoryNotFoundException("A categoria com o código {$id} não existe!", 404);

        return $model;
    }

    /**
     * @param $id
     * @return bool|null
     * @throws CategoryNotFoundException
     */
    public function delete($id) {
        if ($id instanceof Category) $id = $id->id;

        $category = $this->get($id);

        /** @var HasMany $posts */
        $posts = $category->posts();

        if ($posts->count() > 0)
            $posts->delete();

        return $category->delete();
    }

    public function update($id, array $attributes = []) {
        if ($id instanceof Category) {
            $category = $id;
        } else {
            $category = $this->get($id);
        }

        if (isset($attributes['name'])) {
            $nameAvailable = $this->model->where('id', '<>', $id)
                    ->where('name', $attributes['name'])->count() == 0;

            if (!$nameAvailable) throw new \Exception("Ja existe uma categoria com este nome!");
        }

        $category->fill($attributes);
        $category->saveOrFail();
        return $category;
    }

    public function create(array $attributes = []) {
        /** @var \Illuminate\Validation\Validator $validation */
        $validation = Validator::make($attributes, [
            'name' => 'required|unique:categories,name',
        ]);

        if ($validation->fails()) throw new ValidationException($validation);

        $category = $this->model->create($attributes);
        return $category;
    }

}