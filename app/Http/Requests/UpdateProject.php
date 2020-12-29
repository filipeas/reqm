<?php

namespace App\Http\Requests;

use App\Rules\ValidProject;
use App\Rules\ValidUniqueInitials;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProject extends FormRequest
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
            'id' => ['required', 'exists:projects', new ValidProject()],
            'initials' => ['required', 'string', 'max:30', new ValidUniqueInitials()],
            'scope' => ['required', 'string', 'max:255'],
            'product_limits' => ['required'],
            'client_institution' => ['required', 'string', 'max:100'],
            'developer_institution' => ['required', 'string', 'max:100'],
            'acronym_definitions' => ['required'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
        ];
    }
}
