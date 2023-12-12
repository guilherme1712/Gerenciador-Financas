<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContaRequest extends FormRequest
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
            'data' => 'required|date',
            'descricao' => 'required|string',
            'valor' => 'required|numeric',
            'recorrente' => 'required|in:0,1',
            'data_termino_recorrente' => $this->input('recorrente') == '1' ? 'required|date' : 'nullable|date',
            'status' => 'required|in:0,1',
            'banco' => 'required|exists:bancos,id_banco',
            'categoria' => 'nullable|in:1,2,3,4,5',
        ];
    }
}
