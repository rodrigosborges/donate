<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoacoesRequest extends FormRequest
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
            'titulo' => 'required|max:40|min:10',
            'descricao' => 'required|max:1000|min:50',
            'imagem' => 'min:1|max:6'
        ];
    }

    public function messages()
    {
        return [
            'image' => 'São aceitas apenas imagens!',
            'required' => 'Este campo é obrigatório!',
            'imagem.min' => "O anúncio deve conter pelo menos :min imagens",
            'imagem.max' => "O anúncio deve conter no máximo :max imagens",
            'min' => 'Este campo deve conter pelo menos :min caracteres',
            'max' => 'Este campo deve conter no máximo :max caracteres'
        ];
    }
}
