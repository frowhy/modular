<?php

namespace Modules\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class Request extends FormRequest
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
     * @param Validator $validator
     *
     */
    public function withValidator(Validator $validator)
    {
        if ($validator->fails()) {
            abort(422, $validator->errors()->first());
        }
    }
}
