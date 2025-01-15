<?php

namespace App\Http\Requests;

use App\Traits\FormatsValidationErrors;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{

    use FormatsValidationErrors;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:225'],
            'content' => ['required', 'string'],
            'media.*' => ['file', 'mimes:jpg,png,jpeg,mp4,mov,avi,mkv', 'max:10240']
        ];
    }

    protected function failedValidation($validator)
    {
        $response = $this->formatValidationErrors($validator);

        // Throw a ValidationException with the formatted response
        throw new \Illuminate\Validation\ValidationException(
            $validator,
            response()->json($response, 422)
        );
    }
}
