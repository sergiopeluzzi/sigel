<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CompetidoresRequest extends Request
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
            'nome' => 'required|min:3',
            'cidade' => 'required|min:3',
            'apelido' => 'required|min:2',
            'handcapcabeca' => 'required|numeric',
            'handcappe' => 'required|numeric',
        ];
    }
}
