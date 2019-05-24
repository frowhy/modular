<?php

namespace Modules\Example\Http\Requests;

use Modules\Core\Http\Requests\Request;

class ExampleUpdateRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'value' => 'required',
        ];
    }
}
