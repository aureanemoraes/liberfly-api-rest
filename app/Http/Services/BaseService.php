<?php
namespace App\Http\Services;
class BaseService {
    protected function success($data): array {
        return [
            'success' => true,
            'data' => $data
        ];
    }

    protected  function error($errors): array {
        return [
            'success' => false,
            'errors' => $errors
        ];
    }
}
