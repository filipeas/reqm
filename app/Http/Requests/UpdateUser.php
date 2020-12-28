<?php

namespace App\Http\Requests;

use App\Rules\ValidCurrentUser;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
{
    public function response(array $errors)
    {
        return response()->json($errors, 422);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'email_verify' => ['required', 'email', 'exists:users,email', new ValidCurrentUser()]
        ];
    }
}
