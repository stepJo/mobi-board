<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
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
            't_title'       => 'required',
            't_description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            't_title.required'       => 'Task title is required',
            't_description.required' => 'Task description is required'
        ];
    }
}
