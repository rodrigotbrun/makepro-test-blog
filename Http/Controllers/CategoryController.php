<?php

namespace Blog\Http\Controllers;

use Blog\Repositories\CategoryRepository;
use Blog\Repositories\PostRepository;
use Blog\Traits\ApiController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class CategoryController extends BaseController {
    use ValidatesRequests, ApiController;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * CategoryController constructor.
     * @param CategoryRepository $categoryRepository
     * @param PostRepository $postRepository
     */
    public function __construct(CategoryRepository $categoryRepository, PostRepository $postRepository) {
        $this->categoryRepository = $categoryRepository;
        $this->postRepository = $postRepository;
    }

    public function listAll() {
        $all = $this->categoryRepository->listAllPaginated(20);
        return new JsonResponse($all);
    }

    public function listAllPosts($id) {
        try {
            $category = $this->categoryRepository->get($id);
            $all = $this->postRepository->listAllPaginatedForCategory($category, 20);
            return new JsonResponse($all);
        } catch (\Exception $e) {
            return $this->response($e, 404);
        }
    }

    public function get($id) {
        try {
            $category = $this->categoryRepository->get($id);
            return new JsonResponse($category);
        } catch (\Exception $e) {
            return $this->response($e, 404);
        }
    }

    public function delete($id) {
        try {
            $deleted = $this->categoryRepository->delete($id);
            return $this->response([
                'deleted' => $deleted
            ]);
        } catch (\Exception $e) {
            echo $e->getMessage();exit;
            return $this->response($e, 400);
        }
    }

    public function update(Request $request, $id) {
        try {
            $input = $request->input();
            $category = $this->categoryRepository->update($id, $input);
            return $this->response($category);
        } catch (\Exception $e) {
            return $this->response($e);
        }
    }

    public function create(Request $request) {
        try {
            $input = $request->input();
            $category = $this->categoryRepository->create($input);
            return $this->response($category, 201);
        } catch (\Exception $e) {
            return $this->response($e);
        }
    }

}