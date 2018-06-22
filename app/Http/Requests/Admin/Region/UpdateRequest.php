<?php

namespace App\Http\Requests\Admin\Region;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\RegionName;

class UpdateRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
                new RegionName($this, $this->id),
            ],
            'parent_id' => 'nullable|exists:regions,id',
        ];
    }
}
