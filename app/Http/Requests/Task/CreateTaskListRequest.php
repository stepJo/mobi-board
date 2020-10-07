<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class CreateTaskListRequest extends FormRequest
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
            't_id'           => 'required',
            'tl_title'       => 'required',
            'tl_description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            't_id.required'           => 'Task is required',
            'tl_title.required'       => 'Task list title is required',
            'tl_description.required' => 'Task list description is required'
        ];
    }
}
