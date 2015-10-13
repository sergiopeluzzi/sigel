<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EventosRequest extends Request
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
            'nome' => 'required|min:2',
            'descricao' => 'required|min:3',
            'cidade' => 'required|min:2',
            'datainicio' => 'date',
            'datafim' => 'date',
            'maxnuminscricoes' => 'numeric',
            'maxnuminscricoesporpessoa' => 'numeric',
            'maxnuminscricoesporhandcap' => 'numeric',
            'maxnuminscricoescommesmocompetidor' => 'numeric',
            'qntdebois' => 'numeric',
            'pulaquantos' => 'numeric'
        ];
    }
}
