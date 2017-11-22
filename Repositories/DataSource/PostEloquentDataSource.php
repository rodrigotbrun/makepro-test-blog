<?php

namespace Blog\Repositories\DataSource;

use Blog\Exceptions\CategoryNotFoundException;
use Blog\Exceptions\PostNotFoundException;
use Blog\Models\Category;
use Blog\Models\Post;
use Blog\Repositories\PostRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PostEloquentDataSource implements PostRepository {

    /**
     * @var Post
     */
    private $model;

    /**
     * CategoryEloquentDataSource constructor.
     * @param Post $model
     */
    public function __construct(Post $model) {
        $this->model = $model;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|Post[]
     */
    public function listAll() {
        return $this->model->all();
    }

    /**
     * @param int $perPage
     * @return Post[]|\Illuminate\Database\Eloquent\Collection
     */
    public function listAllPaginated($perPage = 15) {
        return $this->model->paginate($perPage);
    }

    /**
     * @param Category $category
     * @return Post[]|\Illuminate\Database\Eloquent\Collection
     */
    public function listAllForCategory(Category $category) {
        return $this->model->where('category', $category->id)
            ->get();
    }

    /**
     * @param Category $category
     * @param int $perPage
     * @return Post[]|\Illuminate\Database\Eloquent\Collection
     */
    public function listAllPaginatedForCategory(Category $category, $perPage = 15) {
        return $this->model->where('category', $category->id)
            ->paginate($perPage);
    }

    /**
     * @param $id
     * @return Post
     * @throws PostNotFoundException
     */
    public function get($id) {
        $model = $this->model->find($id);

        if (empty($model))
            throw new PostNotFoundException("O post com o código {$id} não existe!", 404);

        return $model;
    }

    /**
     * @param $id
     * @return bool|null
     * @throws CategoryNotFoundException
     */
    public function delete($id) {
        if ($id instanceof Post) $id = $id->id;

        $category = $this->get($id);
        return $category->delete();
    }

    public function update($id, array $attributes = []) {
        if ($id instanceof Post) {
            $category = $id;
        } else {
            $category = $this->get($id);
        }

        /** @var \Illuminate\Validation\Validator $validation */
        $validation = Validator::make($attributes, [
            'category' => 'bail|filled|exists:categories,id',
            'title' => 'bail|filled',
            'description' => 'bail|filled',
        ]);

        if($validation->fails()) throw new ValidationException($validation);

        if (isset($attributes['title'])) {
            $nameAvailable = $this->model->where('id', '<>', $id)
                    ->where('title', $attributes['title'])->count() == 0;

            if (!$nameAvailable) throw new \Exception("Ja existe um post com este titulo!");
        }

        $category->fill($attributes);
        $category->saveOrFail();
        return $category;
    }

    public function create(array $attributes = []) {
        /** @var \Illuminate\Validation\Validator $validation */
        $validation = Validator::make($attributes, [
            'category' => 'bail|required|exists:categories,id',
            'title' => 'bail|required|unique:posts,title',
            'description' => 'bail|required',
        ]);

        if($validation->fails()){
            throw new ValidationException($validation);
        }

        $category = $this->model->create($attributes);
        return $category;
    }

}