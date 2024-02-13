<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class ProjectStoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'project_name' => 'string|max:255|required',
            'estimation' => 'numeric|required',
            'release_date' => 'required|date',
            'work_date' => 'required|date',
            'member.*' => 'numeric|required'
        ];
    }
}
