<?php

namespace App\Http\Requests;

use App\Rules\ValidCurrentUser;
use App\Rules\ValidCurrentUserPassword;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordUser extends FormRequest
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
            'email_verify' => ['required', 'email', 'exists:users,email', new ValidCurrentUser()],
            'current_password' => ['required', new ValidCurrentUserPassword()],
            'password' => ['required', 'min:6'],
            'password_confirm' => ['required', 'same:password'],
        ];
    }
}
