<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Page;

class CreatePageRequest extends FormRequest
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
            'name' => 'required',
            'about' => 'required', 
            'picture'=> 'required|url', 
            'cover_photo'=> 'required|url',
        ];
    }
}
