<?php

namespace App\Traits;

trait FormatsValidationErrors
{
    protected function formatValidationErrors($validator)
    {
        $errors = $validator->errors()->toArray();
        $formattedErrors = [];

        foreach ($errors as $field => $messages) {
            $formattedErrors[$field] = $messages[0];
        }

        return [
            "success" => false,
            'data' => ["errors" => $formattedErrors],
            'message' => 'The given data was invalid.',
        ];
    }
}
