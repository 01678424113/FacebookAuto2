<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
    public function rules() {
        return [
            'page_id'=>'required|unique:pages,page_id',
            'page_name'=>'required',
            'id_category'=>'required'
        ];
    }

    public function messages() {
        return [
            'page_id.required'=>'Id page không dược để trống.',
            'page_id.unique'=>'Page này đã tồn tại',
            'page_name.required'=>'Tên page không được để trống',
            'id_category.required'=>'Thể loại page không được để trống'
        ];
    }
}
