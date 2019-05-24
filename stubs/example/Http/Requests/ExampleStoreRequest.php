<?php

namespace Modules\Example\Http\Requests;

use Modules\Core\Http\Requests\Request;

class ExampleStoreRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:examples',
            'value' => 'required',
        ];
    }
}
