<?php

namespace Blog\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

trait ApiController {

    public function response($data, $code = 200) {
        if ($data instanceof ValidationException) {
            $erros = $data->errors();
            $message = '';
            foreach ($erros as $e) {
                foreach ($e as $em) {
                    $message .= $em . ' ';
                }
            }

            $message = trim($message);

            return new JsonResponse([
                'message' => $message,
            ], 400);
        } else if ($data instanceof \Exception) {
            return new JsonResponse([
                'message' => $data->getMessage(),
            ], (($data->getCode() == 0) ? (400) : ($data->getCode())));
        } else {
            return new JsonResponse($data, $code);
        }
    }

}