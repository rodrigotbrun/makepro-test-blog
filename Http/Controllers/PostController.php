<?php

namespace Blog\Http\Controllers;

use Blog\Repositories\PostRepository;
use Blog\Traits\ApiController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class PostController extends BaseController {
    use ValidatesRequests, ApiController;

    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * CategoryController constructor.
     * @param PostRepository $postRepository
     */
    public function __construct(PostRepository $postRepository) {
        $this->postRepository = $postRepository;
    }

    public function listAll(Request $request) {
        $all = $this->postRepository->listAllPaginated(20);

        if ($request->has('withCategory')) {
            $all->load('category');
        }

        return new JsonResponse($all);
    }

    public function get(Request $request, $id) {
        try {
            $post = $this->postRepository->get($id);

            if ($request->has('withCategory')) {
                $post->load('category');
            }

            return new JsonResponse($post);
        } catch (\Exception $e) {
            return $this->response($e, 404);
        }
    }

    public function delete($id) {
        try {
            $deleted = $this->postRepository->delete($id);
            return $this->response([
                'deleted' => $deleted
            ]);
        } catch (\Exception $e) {
            return $this->response($e);
        }
    }

    public function update(Request $request, $id) {
        try {
            $input = $request->input();
            $post = $this->postRepository->update($id, $input);

            if ($request->has('withCategory')) {
                $post->load('category');
            }

            return $this->response($post);
        } catch (\Exception $e) {
            return $this->response($e);
        }
    }

    public function create(Request $request) {
        try {
            $input = $request->input();
            $post = $this->postRepository->create($input);

            if ($request->has('withCategory')) {
                $post->load('category');
            }

            return $this->response($post, 201);
        } catch (\Exception $e) {
            return $this->response($e);
        }
    }

}